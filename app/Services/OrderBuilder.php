<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/28
 * Time: 上午11:44
 */

namespace App\Services;


use App\Entities\Merchandise;
use App\Entities\ShoppingCart;
use App\Entities\Order;
use App\Entities\OrderItem;
use App\Entities\SKUProduct;
use App\Entities\ShopMerchandise;
use App\Entities\ShopProduct;
use App\Entities\ActivityMerchandise;
use App\Entities\User;
use App\Repositories\ActivityMerchandiseRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderPostRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ShopMerchandiseRepository;
use App\Repositories\ShopProductRepository;
use App\Repositories\SKUProductRepository;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class OrderBuilder implements InterfaceServiceHandler
{
    /**
     * @var Collection|null $input 系统出入待处理数据
     * */
    protected $input = null;

    /**
     * @var OrderRepository $order
     * */
    protected $order = null;

    /**
     * @var OrderItemRepository $orderItem
     * */
    protected $orderItem = null;


    /**
     * @var OrderPostRepository $orderPost
     * */
    protected $orderPost = null;

    /**
     * @var User|null
     * */
   // protected $buyer = null;

    /**
     * @var MerchandiseRepository|null
     * */
    protected $merchandise = null;

    /**
     * @var SKUProductRepository|null
     * */
    protected $skuProduct = null;

    /**
     * @var array $shoppingCartIds
     */
    protected $shoppingCartIds = [];

    /**
     * @var Auth
     * */
    protected $auth = null;

    protected $updateStockNumSqlContainer = [
        'sku' => [],
        'merchandise' => []
    ];

    public function __construct( Collection $input,
                                 Auth $auth, 
                                 OrderRepository $order,
                                 MerchandiseRepository $merchandise,
                                 OrderItemRepository $orderItem = null,
                                 SKUProductRepository $skuProduct = null,
                                 OrderPostRepository $orderPost = null)
    {
        $this->auth = $auth;
        $this->input = $input;
        $this->order = $order;
        $this->orderPost = $orderPost;
        $this->orderItem = $orderItem;
        $this->merchandise = $merchandise;
        $this->skuProduct = $skuProduct;
    }

    public function setInput(array  $input)
    {
        $this->input = collect($input);
        return $this;
    }

    /**
     * @return Order
     * @throws
     * */
    public function handle()
    {
        // TODO: Implement handle() method.
        //$this->buyer = $this->buyer ? $this->buyer : $this->auth->user();
        $order = $this->input->only([
            'receiver_name',
            'receiver_mobile',
            'comment',
            'send_date',
            'send_batch',
            'pick_up_method',
            'card_id',
            'card_code',
            'shop_id',
            'activity_id',
            'merchandise_num',
            'status',
            'years',
            'month',
            'day',
            'week',
            'hour',
            'total_amount',
            'discount_amount',
            'payment_amount',
            'receiver_city',
            'receiver_district',
            'receiver_address',
            'type',
            'pay_type',
            'open_id',
            'app_id',
            'wechat_app_id',
            'ali_app_id',
            'customer_id',
            'ip',
            'member_id',
            'receiving_shop_id'
        ]);

        $order['status'] = Order::WAIT;
        if((int)$order['type'] === Order::OFF_LINE_PAYMENT_ORDER) {
            $orderItem = [
                'total_amount' => $order->get('total_amount'),
                'discount_amount' => $order->get('discount_amount', 0),
                'payment_amount'  => $order->get('payment_amount'),
                'shop_id'   => (isset($this->input['shop_id']) ? $this->input['shop_id'] : null),
                'customer_id' => $order->get('customer_id'),
                'status' => $order->get('status'),
                'member_id' => $order->get('member_id')
            ];
            $orderItem = collect($orderItem);
            $orderItems = collect();
            $orderItems->push($orderItem);
        }else{
            $orderItems = $this->input['order_items'];
            $this->shoppingCartIds = $this->input['shopping_cart_ids'];
            if(is_array($orderItems)) {
                $orderItems = collect($orderItems);
            }
            $orderItems = $orderItems->map(function ($orderItem) {
                return is_array($orderItem) ? collect($orderItem) : $orderItem;
            });
        }

        if($orderItems && $orderItems->count()){
            $orderItems = $this->buildOrderItems($orderItems);
            $this->checkOrder($orderItems, $order);
        }
        $shoppingCartIds = $this->shoppingCartIds;
        Log::info('====== order model =======', $order->toArray());
        return DB::transaction(function () use($order, $orderItems ,$shoppingCartIds){
            /**
             *@var Order $orderModel
             * */
            $orderModel = $this->order->create($order->toArray());
            Log::info('order model', $orderModel->toArray());
            if($orderModel && $orderItems) {
                $orderItems = $orderItems->map(function (Collection $orderItem) use($orderModel) {
                    $orderItem['activity_id'] =  $orderModel->activityId;
                    $orderItem['app_id'] =  $orderModel->appId;
                    $orderItem['member_id'] =  $orderModel->memberId;
                    $orderItem['status'] =  $orderModel->status;
                    if(!isset($orderItem['send_date']) || !$orderItem['send_date'])
                        $orderItem['send_date'] = $orderModel->sendDate;
                    if(!isset($orderItem['send_batch']) || !$orderItem['send_batch'])
                        $orderItem['send_batch'] = $orderModel->sendBatch;
                    $orderItem['type'] = $orderModel->type;
                    $orderItem['pick_up_method'] = $orderModel->pickUpMethod;
                    $orderItem['code'] = app('uid.generator')->getSubUid($orderModel->code, ORDER_SEGMENT_MAX_LENGTH);
                    return new OrderItem($orderItem->toArray());
                });
                $orderModel->orderItems()->saveMany($orderItems);
            }

            $this->updateStockNum();

            $this->delete($shoppingCartIds);

            return $orderModel;
        });
    }

    protected function delete(array $shoppingCartIds){
        ShoppingCart::destroy($shoppingCartIds);
    }

    protected function updateStockNum() {
         collect($this->updateStockNumSqlContainer['sku'])->map(/**
         * @param SKUProduct|ShopProduct $sku
         * @return string
         */
            function ( $sku) {
                if(get_class($sku) === SKUProduct::class) {
                    return/** @lang text */
                        DB::update("UPDATE `sku_products` SET 
                        `stock_num` = {$sku->stockNum},
                        `sell_num` = {$sku->sellNum} 
                        WHERE `id` = {$sku->id}");

                }elseif(get_class($sku) === ShopProduct::class){
                    return /** @lang text */
                        DB::update("UPDATE `shop_products` SET 
                        `stock_num` = {$sku->stockNum},
                        `sell_num` = {$sku->sellNum} 
                        WHERE `id` = {$sku->id}");
                }

        });

        collect($this->updateStockNumSqlContainer['merchandise'])->map(/**
         * @param Merchandise|ShopMerchandise|ActivityMerchandise $merchandise
         * @return string
         */
            function ($merchandise) {
            switch(get_class($merchandise)) {
                case Merchandise::class: {
                    return /** @lang text */
                        DB::update("UPDATE `merchandises` SET 
                        `stock_num` = {$merchandise->stockNum} ,
                        `sell_num` = {$merchandise->sellNum} 
                        WHERE `id` = {$merchandise->id}");
                    break;
                }
                case ShopMerchandise::class: {
                    return /** @lang text */
                        DB::update("UPDATE `shop_merchandises` SET
                         `stock_num` = {$merchandise->stockNum} ,
                         `sell_num` = {$merchandise->sellNum} 
                         WHERE `id` = {$merchandise->id}");
                    break;
                }
                case ActivityMerchandise::class: {
                    return /** @lang text */
                        DB::update("UPDATE `activity_merchandises` SET 
                        `stock_num` = {$merchandise->stockNum} ,
                        `sell_num` = {$merchandise->sellNum} 
                        WHERE `id` = {$merchandise->id}");
                    break;
                }
            }
        });
    }

    protected function buildOrderItems (Collection $orderItems)
    {
        return $orderItems->map(/**
         * @param Collection $orderItem
         * @return Collection|null|static
         */
            function ( Collection $orderItem){
            $subOrder = null;
            if(isset($orderItem['sku_product_id']) && $orderItem['sku_product_id']) {
                if($orderItem['activity_id']) {
                    $repository = app()->make(ActivityMerchandiseRepository::class);
                    $product = $repository->scopeQuery(function (ActivityMerchandise $merchandise) use($orderItem){
                        return $merchandise->with('merchandise')->whereProductId($orderItem['sku_product_id']);
                    })->first();

                }elseif($orderItem['shop_id']) {
                    $repository = app()->make(ShopProductRepository::class);
                    $product = $repository->scopeQuery(function (ShopMerchandise $merchandise) use($orderItem){
                        return $merchandise->with('merchandise')->whereProductId($orderItem['sku_product_id']);
                    })->first();
                }else{
                    $repository =$this->skuProduct->with('merchandise');
                    $product = $repository->find($orderItem['sku_product_id']);
                }

                if(!$product) {
                    throw new NotFoundResourceException('购买子产品不存在！');
                }

                $orderItemProduct = $this->buildOrderItemProduct($product, $orderItem['quality']);
                $subOrder = $this->buildOrderItem($product, $orderItem['quality'], $orderItem['customer_id']);
                $subOrder = $subOrder->merge( $orderItemProduct);
            }elseif (isset($orderItem['merchandise_id'])) {
                if($orderItem['activity_id']) {
                    $repository = app()->make(ActivityMerchandiseRepository::class);
                    $goods = $repository->scopeQuery(function (ActivityMerchandise $merchandise) use($orderItem){
                        return $merchandise->with('merchandise')->whereMerchandiseId($orderItem['merchandise_id']);
                    })->first();
                }elseif($orderItem['shop_id']) {
                    $repository = app()->make(ShopMerchandiseRepository::class);
                    $goods = $repository->scopeQuery(function (ShopMerchandise $merchandise) use($orderItem){
                        return $merchandise->with('merchandise')->whereMerchandiseId($orderItem['merchandise_id']);
                    })->first();
                }else{
                    $repository = $this->merchandise;
                    $goods = $repository->find($orderItem['merchandise_id']);
                }
                if(!$goods) {
                    throw new NotFoundResourceException('购买产品不存在！');
                }
                $orderItemProduct = $this->buildOrderItemProduct($goods, $orderItem['quality']);
                $subOrder = $this->buildOrderItem($goods, $orderItem['quality'], $orderItem['customer_id']);
                $subOrder = $subOrder->merge( $orderItemProduct);
            }
            if($subOrder){
                $this->checkOrderItem($subOrder, $orderItem->toArray());
            }
            return $subOrder ? $subOrder : $orderItem;
        });
    }

    protected function checkOrder(Collection $orderItems, $order) {
        $errors = null;
        if ($orderItems->sum('total_amount') != $order->get('total_amount', 0)) {
            $errors = new MessageBag([
                'total_amount' => '订单总金额有误无法提交'
            ]);
        } elseif ((int)($orderItems->sum('payment_amount') * 100 - $order->get('discount_amount', 0) * 100 )  != (int)($order->get('payment_amount', 0) * 100)) {
            $errors = new MessageBag([
                'payment_amount' => '订单实际支付金额有误无法提交'
            ]);
        }
        if($errors) {
            \Log::debug('errors', $errors->toArray());
            throw new ValidationHttpException($errors);
        }
    }

    protected function checkOrderItem (Collection $orderItem, array $input)
    {
        $errors = null;
        Log::info('order item', [$orderItem->toArray(), $input]);
        if($input['total_amount'] !== $orderItem->get('total_amount', 0)) {
            $errors = new MessageBag([
                'total_amount' => '子订单总金额有误无法提交'
            ]);
        } elseif ($input['discount_amount'] !== $orderItem->get('discount_amount', 0) ) {
            $errors = new MessageBag([
                'discount_amount' => '子订单优惠金额有误无法提交'
            ]);
        } elseif ($input['payment_amount'] !== $orderItem->get('payment_amount', 0)) {
            $errors = new MessageBag([
                'payment_amount' => '子订单实际支付金额有误无法提交'
            ]);
        }

        if($errors) {
            throw new ValidationHttpException($errors);
        }
    }

    /**
     * 创建order_items表单项
     * @param ShopMerchandise|ShopProduct|ActivityMerchandise|SKUProduct|Merchandise|Model $model
     * @param int $quality
     * @param $customerId
     * @return Collection
     * */
    protected function buildOrderItem($model, int $quality, $customerId = null)
    {
        if($model->stockNum < 0) {
            Log::info('库存不足 (1)', [$model->stockNum, $quality, $model]);
            throw new ValidationHttpException(new MessageBag([
                'quality' => 'SKU库存不足'
            ]));
        }
        Log::info('order item SKUProduct/Merchandise', [$model]);

        if ($model instanceof ShopMerchandise || $model instanceof ShopProduct || $model instanceof ActivityMerchandise) {
            $sellPrice = $model->merchandise->sellPrice;
        }else {
            $sellPrice = $model->sellPrice;
        }

        $data['customer_id'] = $customerId;
        $data['shop_id'] = isset($this->input['shop_id']) ? $this->input['shop_id'] : null;
        $data['total_amount'] =  $sellPrice * $quality;
        $data['discount_amount'] = 0;
        $data['payment_amount'] = $data['total_amount'] - $data['discount_amount'];
        return collect($data);
    }

    /**
     * 创建订单子项中的产品信息表单项
     * @param SKUProduct|Merchandise|Model $model
     * @param int $quality
     * @return Collection
     * */
    protected function buildOrderItemProduct ($model, int $quality)
    {
        if($model->stockNum < $quality) {
            Log::info('库存不足 (2)', [$model->stockNum, $quality]);
            throw new ValidationHttpException(new MessageBag([
                'quality' => 'SKU库存不足'
            ]));
        }
        if(get_class($model) === SKUProduct::class) {
            $this->skuProduct($model, $quality);
            $this->merchandise($model->merchandise, $quality);
        }else {
            $this->merchandise($model, $quality);
        }
        $data['quality'] = $quality;
        $merchandise = null;

        if ($model instanceof SKUProduct) {
            $data['merchandise_id'] = $model->merchandiseId;
            $data['sku_product_id'] = $model->id;
            $merchandise = $model->merchandise;
        }elseif ($model instanceof Merchandise) {
            $data['merchandise_id'] = $model->id;
            $merchandise = $model;
        }elseif ($model instanceof ActivityMerchandise){
            $data['merchandise_id'] = $model->merchandiseId;
            $merchandise = $model->merchandise;
        }elseif ($model instanceof ShopMerchandise) {
            $data['merchandise_id'] = $model->merchandiseId;
            $merchandise = $model->merchandise;
        }elseif ($model instanceof ShopProduct) {
            $data['merchandise_id'] = $model->merchandiseId;
            $data['sku_product_id'] = $model->skuProductId;
            $merchandise = $model->merchandise;
        }
        $data = array_merge($data, $merchandise->only([
            'origin_price',
            'sell_price',
            'cost_price',
            'main_image'
        ]));
        $data['merchandise_name'] = $merchandise->name;
        return collect($data);
    }

    /**
     * @param SKUProduct|ShopProduct $model
     * @param int $quality
     * */
    protected function skuProduct($model, int $quality){
        $sku = isset($this->updateStockNumSqlContainer['sku'][$model->code]) ? $this->updateStockNumSqlContainer['sku'][$model->code] : null;
        if(!$sku) {
            $sku = $this->updateStockNumSqlContainer['sku'][$model->code] = $model;
        }
        $sku->stockNum -= $quality;
        $sku->sellNum += $quality;
    }


    /**
     * @param Merchandise|ShopMerchandise|ActivityMerchandise $model
     * @param int $quality
     * */
    protected function merchandise($model, int $quality){
        $merchandise = isset($this->updateStockNumSqlContainer['merchandise'][$model->code]) ?
            $this->updateStockNumSqlContainer['merchandise'][$model->code] : null;
        if(!$merchandise) {
            $this->updateStockNumSqlContainer['merchandise'][$model->code] = $model;
            $merchandise = $model;
        }
        $merchandise->stockNum -= $quality;
        $merchandise->sellNum += $quality;
    }
}