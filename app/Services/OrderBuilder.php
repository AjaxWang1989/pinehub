<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/28
 * Time: 上午11:44
 */

namespace App\Services;


use App\Entities\Merchandise;
use App\Entities\Order;
use App\Entities\SKUProduct;
use App\Entities\User;
use App\Repositories\MerchandiseRepositoryEloquent;
use App\Repositories\OrderItemMerchandiseRepositoryEloquent;
use App\Repositories\OrderItemRepositoryEloquent;
use App\Repositories\OrderPostRepositoryEloquent;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\SKUProductRepositoryEloquent;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;

class OrderBuilder implements InterfaceServiceHandler
{
    /**
     * @var Collection|null $input 系统出入待处理数据
     * */
    protected $input = null;

    /**
     * @var OrderRepositoryEloquent $order
     * */
    protected $order = null;

    /**
     * @var OrderItemRepositoryEloquent $orderItem
     * */
    protected $orderItem = null;

    /**
     * @var OrderItemMerchandiseRepositoryEloquent $orderItemMerchandise
     * */
    protected $orderItemMerchandise = null;

    /**
     * @var OrderPostRepositoryEloquent $orderPost
     * */
    protected $orderPost = null;

    /**
     * @var User|null
     * */
    protected $buyer = null;

    /**
     * @var MerchandiseRepositoryEloquent|null
     * */
    protected $merchandise = null;

    /**
     * @var SKUProductRepositoryEloquent|null
     * */
    protected $skuProduct = null;

    /**
     * @var Auth
     * */
    protected $auth = null;

    public function __construct(Collection $input, $auth, OrderRepositoryEloquent $order,MerchandiseRepositoryEloquent $merchandise,
                                OrderItemRepositoryEloquent $orderItem = null,SKUProductRepositoryEloquent $skuProduct = null,
                                OrderItemMerchandiseRepositoryEloquent $orderItemMerchandise =null, OrderPostRepositoryEloquent $orderPost = null)
    {
        $this->auth = $auth;
        $this->input = $input;
        $this->order = $order;
        $this->orderPost = $orderPost;
        $this->orderItem = $orderItem;
        $this->orderItemMerchandise = $orderItemMerchandise;
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
            'buyer_id',
            'ip'
        ]);
        $order['status'] = Order::WAIT;
        if((int)$order['type'] === Order::OFF_LINE_PAY) {
            $orderItem = [
                'total_amount' => $order->get('total_amount'),
                'discount_amount' => $order->get('discount_amount', 0),
                'payment_amount'  => $order->get('payment_amount'),
                'shop_id'   => (isset($this->input['shop_id']) ? $this->input['shop_id'] : null),
                'buyer_id' => $order->get('buyer_id'),
                'status' => $order->get('status')
            ];
            $orderItem = collect($orderItem);
            $orderItems = collect();
            $orderItems->push($orderItem);
        }else{
            $orderItems = $this->input->only(['order_items']);
        }

        if($orderItems && $orderItems->count()){
            $orderItems = $this->buildOrderItems($orderItems);
            $this->checkOrder($orderItems, $order);
        }
        /**
         *@var Order
         * */
        return DB::transaction(function () use($order, $orderItems){
            $orderModel = $this->order->create($order->toArray());
            if($orderModel && $orderItems) {
                $orderItems->map(function (Collection $orderItem) use($orderModel) {
                    $orderItem['order_id'] = $orderModel->id;
                    $orderItem['code'] = app('uid.generator')->getSubUid($orderModel->code, ORDER_SEGMENT_MAX_LENGTH);
                    $orderItemModel = $this->orderItem->create($orderItem->except(['order_item_product'])
                        ->toArray());
                    if(isset($orderItem['order_item_product'])){
                        $orderItem['order_item_product']['order_id'] = $orderModel->id;
                        $orderItem['order_item_product']['order_item_id'] = $orderItemModel->id;
                        $this->orderItemMerchandise->create($orderItem->only(['order_item_product'])->toArray());
                    }
                });
            }
            return $orderModel;
        });
    }

    protected function buildOrderItems (Collection $orderItems)
    {
        return $orderItems->map(function (Collection $orderItem){
            $subOrder = null;
            if(isset($orderItem['sku_product_id'])) {
                $product = $this->skuProduct->find($orderItem['sku_product_id']);
                $orderItemProduct = $this->buildOrderItemProduct($product, $orderItem['quality']);
                $subOrder = $this->buildOrderItem($product, $orderItem['quality'], $orderItem['buyer_id']);
                $subOrder['order_item_product'] = $orderItemProduct;
            }elseif (isset($orderItem['merchandise_id'])) {
                $goods = $this->merchandise->find($orderItem['merchandise_id']);
                $orderItemProduct = $this->buildOrderItemProduct($goods, $orderItem['quality']);
                $subOrder = $this->buildOrderItem($goods, $orderItem['quality'], $orderItem['buyer_id']);
                $subOrder['order_item_product'] = $orderItemProduct;
            }
            if($subOrder){
                $this->checkOrderItem($subOrder, $orderItem);
            }
            return $subOrder ? $subOrder : $orderItem;
        });
    }

    protected function checkOrder(Collection $orderItems, $order) {
        $errors = null;
        \Log::debug('order items total amount sum :'.$orderItems->sum('total_amount').' order total amount '.$order['total_amount']);
        if ($orderItems->sum('total_amount') != $order->get('total_amount', 0)) {
            $errors = new MessageBag([
                'total_amount' => '订单总金额有误无法提交'
            ]);
        } elseif ($orderItems->sum('discount_amount') != $order->get('discount_amount', 0)) {
            $errors = new MessageBag([
                'discount_amount' => '订单优惠金额有误无法提交'
            ]);
        } elseif ( $orderItems->sum('payment_amount') != $order->get('payment_amount', 0) ) {
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
     * @param SKUProduct|Merchandise|Model $model
     * @param int $quality
     * @param $buyerId
     * @return Collection
     * */
    protected function buildOrderItem($model, int $quality, $buyerId = null)
    {
        $data['buyer_id'] = $buyerId;
        $data['shop_id'] = isset($this->input['shop_id']) ? $this->input['shop_id'] : null;
        $data['total_amount'] =  $model->sellPrice * $quality;
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
        $data = $model->only([
            'origin_price',
            'sell_price',
            'cost_price',
            'main_image'
        ]);
        $data['quality'] = $quality;
        if ($model instanceof SKUProduct) {
            $data['merchandise_id'] = $model->merchandiseId;
            $data['sku_product_id'] = $model->id;
        }elseif ($model instanceof Merchandise) {
            $data['merchandise_id'] = $model->id;
        }
        return collect($data);
    }
}