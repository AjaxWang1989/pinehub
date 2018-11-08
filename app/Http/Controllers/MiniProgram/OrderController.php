<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 18:44
 */

namespace App\Http\Controllers\MiniProgram;


use App\Entities\CustomerTicketCard;
use App\Entities\MemberCard;
use App\Entities\Order;
use App\Entities\ShoppingCart;
use App\Exceptions\UnifyOrderException;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Http\Requests\MiniProgram\OrderCreateRequest;
use App\Repositories\OrderRepository;
use App\Repositories\CardRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\MemberCardRepository;
use App\Repositories\CustomerTicketCardRepository;
use App\Transformers\Mp\OrderTransformer;
use App\Transformers\Mp\OrderStoreBuffetTransformer;
use App\Transformers\Mp\OrderStoreSendTransformer;
use App\Transformers\Mp\StatusOrdersTransformer;
use App\Transformers\Mp\StoreOrdersSummaryTransformer;
use App\Repositories\ShopRepository;
use App\Http\Response\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Application;
use App\Exceptions\UserCodeException;
use Illuminate\Support\Facades\Cache;

/**
 * @property CardRepository cardRepository
 */
class OrderController extends Controller
{
    /**
     * @var OrderRepository|null
     */
    protected $orderRepository = null;

    /**
     * @var null
     */
    protected $userTicketRepository = null;

    /**
     * @var ShoppingCartRepository|null
     */
    protected $shoppingCartRepository = null;

    /**
     * @var MerchandiseRepository|null
     */
    protected $merchandiseRepository = null;

    /**
     * @var ShopRepository|null
     */
    protected $shopRepository = null;

    /**
     * @var OrderItemRepository|null
     */
    protected $orderItemRepository = null;

    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var MemberCardRepository|null
     */
    protected $memberCardRepository = null;

    /**
     * @var CustomerTicketCardRepository|null
     */
    protected $customerTicketCardRepository = null;

    /**
     * OrderController constructor.
     * @param AppRepository $appRepository
     * @param CustomerTicketCardRepository $customerTicketCardRepository
     * @param MemberCardRepository $memberCardRepository
     * @param Application $app
     * @param OrderItemRepository $orderItemRepository
     * @param ShopRepository $shopRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param CardRepository $cardRepository
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param OrderRepository $orderRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,
                                CustomerTicketCardRepository $customerTicketCardRepository,
                                MemberCardRepository $memberCardRepository,
                                Application $app,
                                OrderItemRepository $orderItemRepository ,
                                ShopRepository $shopRepository,
                                MerchandiseRepository $merchandiseRepository ,
                                CardRepository $cardRepository,
                                ShoppingCartRepository $shoppingCartRepository,
                                OrderRepository $orderRepository ,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->appRepository                = $appRepository;
        $this->orderRepository              = $orderRepository;
        $this->cardRepository               = $cardRepository;
        $this->shoppingCartRepository       = $shoppingCartRepository;
        $this->merchandiseRepository        = $merchandiseRepository;
        $this->shopRepository               = $shopRepository;
        $this->orderItemRepository          = $orderItemRepository;
        $this->app                          = $app;
        $this->memberCardRepository         = $memberCardRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
    }

    /**
     * 重新支付订单
     */

    public function againOrder(int $orderId){
        $order = $this->orderRepository->findWhere(['id'=>$orderId])->first();
        return $this->order($order);
    }

    public function order($order){

        return DB::transaction(function () use(&$order){
            //跟微信打交道生成预支付订单
            $result = app('wechat')->unify($order, $order->wechatAppId, app('tymon.jwt.auth')->getToken());
            if($result['return_code'] === 'SUCCESS'){
                $order->status = Order::MAKE_SURE;
                $order->paidAt = date('Y-m-d H:i:s',time());
                $order->save();
                $sdkConfig  = app('wechat')->jssdk($result['prepay_id'], $order->wechatAppId);
                $result['sdk_config'] = $sdkConfig;

                return $this->response(new JsonResponse($result));
            }else{
                throw new UnifyOrderException($result['return_msg']);
            }
        });
    }

    /**
     * 创建订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function createOrder(OrderCreateRequest $request)
    {
            $user = $this->mpUser();
            $orders = $request->all();
            if ($orders['receiver_address'] && $orders['build_num'] && $orders['room_num']){
                $address = [
                    'receiver_address' => $orders['receiver_address'],
                    'build_num'        => $orders['build_num'],
                    'room_num'         => $orders['room_num']
                ];
                $orders['receiver_address'] = json_encode($address);
            }

            if (isset($orders['send_time']) && $orders['send_time']){
                //拆分字符串
                $sendTime = explode('-',$orders['send_time']);
                //去除字符串中的空格
                $removeSpace = str_replace(' ','',$sendTime);
                $orders['send_start_time'] = date('Y-m-d '.$removeSpace[0].':'.'00',time());
                $orders['send_end_time']   = date('Y-m-d '.$removeSpace[1].':'.'00',time());
            }

            $orders['app_id'] = $user->appId;
            $orders['member_id'] = $user->memberId;
            $orders['wechat_app_id'] = $user->platformAppId;
            $orders['customer_id'] = $user->id;
            $orders['open_id']  = $user->platformOpenId;

            $customerTicketRecord = $user->ticketRecords()->with('card')
                ->where([
                    'card_id' => $orders['card_id'],
                    'status'  => CustomerTicketCard::STATUS_ON,
                    'active'  => CustomerTicketCard::ACTIVE_ON
                ])
                ->orderBy('id', 'asc')
                ->first();

            if ($customerTicketRecord){
                $card = $customerTicketRecord['card'];

                $orders['discount_amount'] = $card ? $card['card_info']['reduce_cost']/100 : '';

                $orders['card_id'] = $card['card_id'];

            }else{
                return $this->response(new JsonResponse(['card_id' => '登陆用户没有此优惠券']));
            }

            $orders['shop_id'] = isset($orders['store_id']) ? $orders['store_id'] : null;

            //有店铺id就是今日店铺下单的购物车,有活动商品id就是在活动商品里的购物车信息,两个都没有的话就是预定商城下单的购物车
            if (isset($orders['store_id']) && $orders['store_id']){
                $shoppingCarts = $this->shoppingCartRepository
                    ->findWhere([
                        'customer_id' => $user->id,
                        'shop_id'     =>$orders['store_id']
                    ]);

            }elseif (isset($orders['activity_id']) && $orders['activity_id']){
                $shoppingCarts = $this->shoppingCartRepository
                    ->findWhere([
                        'customer_id'              => $user->id,
                        'activity_id' => $orders['activity_id']]);

            }else{
                $shoppingCarts = $this->shoppingCartRepository
                    ->findWhere([
                        'customer_id'               => $user->id,
                        'activity_id'  => null,
                        'shop_id'                   => null
                    ]);

            }

            $orders['merchandise_num'] = $shoppingCarts->sum('quality');
            $orders['total_amount']    = $shoppingCarts->sum('amount');
            $orders['payment_amount']  = $orders['total_amount'] - $orders['discount_amount'];

            $orders['years'] = date('Y', time());
            $orders['month'] = date('d', time());
            $orders['week']  = date('w', time()) === 0 ? 7 : date('w', time());
            $orders['hour']  = date('H', time());

            $orderItems = [];
            $deleteIds  = [];
            //取出购物车商品信息组装成一个子订单数组
            foreach ($shoppingCarts as $k => $v) {
                $orderItems[$k]['activity_id'] = $v['activity_id'];
                $orderItems[$k]['shop_id'] = $v['shop_id'];
                $orderItems[$k]['customer_id'] = $v['customer_id'];
                $orderItems[$k]['merchandise_id'] = $v['merchandise_id'];
                $orderItems[$k]['quality'] = $v['quality'];
                $orderItems[$k]['total_amount'] = $v['amount'];
                $orderItems[$k]['discount_amount'] = 0;
                $orderItems[$k]['payment_amount'] = $v['amount'];
                $orderItems[$k]['sku_product_id'] = $v['sku_product_id'];
                $orderItems[$k]['status'] = Order::WAIT;
                $deleteIds[] = $v['id'];
            }

            $orders['shopping_cart_ids']    = $deleteIds;
            $orders['order_items']          = $orderItems;

            //生成提交中的订单
            $order = $this->app
                ->make('order.builder')
                ->setInput($orders)
                ->handle();

            //更新优惠券状态为已使用
            $card_use = $this->customerTicketCardRepository->update(['status'=>CustomerTicketCard::STATUS_USE],$customerTicketRecord['id']);


            return $this->order($order);
    }

    /**
     * 自提订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeBuffetOrders(Request $request){
        $user = $this->mpUser();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'  =>  $user['member_id']])
            ->first();

        if ($shopUser){
            $userId = $shopUser['id'];
            $sendTime = $request->all();

            //查询今日下单和预定商城的所有自提订单
            $items = $this->orderRepository
                ->storeBuffetOrders($sendTime,  $userId);

            return $this->response()
                ->paginator($items,new OrderStoreBuffetTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 配送订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeSendOrders(Request $request)
    {
        $user = $this->mpUser();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'   =>  $user['member_id']])
            ->first();

        if ($shopUser) {
            $userId     = $shopUser['id'];
            $sendTime   = $request->all();

           //查询今日下单和预定商城的所有配送订单
            $items = $this->orderRepository
                ->storeSendOrders($sendTime,$userId);

            return $this->response()->paginator($items,new OrderStoreSendTransformer());
        }

        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 所有订单信息
     * @param string $status
     *
     * @return \Dingo\Api\Http\Response
     */

    public function orders(string  $status){
        $user   = $this->mpUser();

        $customerId = $user['id'];

        $items = $this->orderRepository
            ->orders($status,   $customerId);
        return $this->response()
            ->paginator($items, new StatusOrdersTransformer());
    }

    /**
     * 销售订单汇总
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeOrdersSummary(Request $request){
        $user = $this->mpUser();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'  =>  $user['member_id']])
            ->first();

        if ($shopUser) {
            $userId = $shopUser['id'];

            $request = $request->all();

            $items = $this->orderRepository
                ->storeOrdersSummary($request,  $userId);
            return $this->response()
                ->paginator($items, new StoreOrdersSummaryTransformer());
        }

        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 取消订单
     * @param int $id
     */
    public function cancelOrder(int $id){
        $status = ['status' => Order::CANCEL];

        $statusOrder = $this->orderRepository->find($id);

        if ($statusOrder['status'] == '100' || $statusOrder['status'] == '200'){

            $items = $this->orderItemRepository
                ->findWhere(['order_id' => $id]);


            foreach ($items as $v) {
                $this->orderItemRepository
                    ->update($status, $v['id']);
            }

            $item = $this->orderRepository
                ->update($status, $id);

            return $this->response()->item($item, new StatusOrdersTransformer());
        }else{
            $errCode = '状态提交错误';
            throw new UserCodeException($errCode);
        }

    }

    /**
     * 确认订单
     * @param int $id
     * @return mixed
     */
    public function confirmOrder(int $id){
        $status = ['status' => Order::COMPLETED];

        $statusOrder = $this->orderRepository->find($id);

        if ($statusOrder['status'] == '300' || $statusOrder['status'] == '400'){

            $items = $this->orderItemRepository
                ->findWhere(['order_id'=>$id]);

            foreach ($items as $v){
                $this->orderItemRepository
                    ->update($status,$v['id']);
            }

            $item = $this->orderRepository
                ->update($status, $id);

            return $this->response()->item($item, new StatusOrdersTransformer());
        }else{
            $errCode = '状态提交错误';
            throw new UserCodeException($errCode);
        }

    }

}