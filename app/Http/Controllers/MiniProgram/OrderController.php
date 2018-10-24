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
use Laravel\Lumen\Application;
use Illuminate\Support\Facades\Cache;

/**
 * @property CardRepository cardRepository
 */
class OrderController extends Controller
{
    protected $orderRepository = null;
    protected $userTicketRepository = null;
    protected $shoppingCartRepository = null;
    protected $merchandiseRepository = null;
    protected $shopRepository = null;
    protected $orderItemRepository = null;
    protected $app = null;
    protected $memberCardRepository = null;
    protected $customerTicketCardRepository = null;

    /**
     * OrderController constructor.
     * @param AppRepository $appRepository
     * @param ShopRepository $shopRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param CardRepository $cardRepository
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param OrderRepository $orderRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,CustomerTicketCardRepository $customerTicketCardRepository,MemberCardRepository $memberCardRepository,Application $app,OrderItemRepository $orderItemRepository ,ShopRepository $shopRepository,MerchandiseRepository $merchandiseRepository ,CardRepository $cardRepository,ShoppingCartRepository $shoppingCartRepository,OrderRepository $orderRepository ,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->orderRepository = $orderRepository;
        $this->cardRepository = $cardRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shopRepository = $shopRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->app = $app;
        $this->memberCardRepository = $memberCardRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
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

        $orders['shop_id'] = $orders['store_id'] ? $orders['store_id'] : null;

        if (isset($orders['store_id']) && $orders['store_id']){
            $shoppingCarts = $this->shoppingCartRepository
                ->findWhere([
                    'customer_id' => $user->id,
                    'shop_id'     =>$orders['store_id']
                ]);

        }elseif (isset($orders['activity_merchandises_id']) && $orders['activity_merchandises_id']){
            $shoppingCarts = $this->shoppingCartRepository
                ->findWhere([
                'customer_id'              => $user->id,
                'activity_merchandises_id' => $orders['activity_merchandises_id']]);

        }else{
            $shoppingCarts = $this->shoppingCartRepository
                ->findWhere([
                'customer_id'               => $user->id,
                'activity_merchandises_id'  => null,
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

        foreach ($shoppingCarts as $k => $v) {
            $orderItems[$k]['activity_merchandises_id'] = $v['activity_merchandises_id'];
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
        return DB::transaction(function () use(&$orders){
            $order = $this->app
                ->make('order.builder')
                ->setInput($orders)
                ->handle();
//            $result = app('wechat')->unify($order, $order->wechatAppId);
            $result = ['return_code' =>'SUCCESS'];
            if($result['return_code'] === 'SUCCESS'){
                $order->status = Order::MAKE_SURE;

                $order->save();
                return $order;
                $sdkConfig  = app('wechat')->jssdk($result['prepay_id'], $order->wechatAppId);

                $result['sdk_config'] = $sdkConfig;

                return $this->response(new JsonResponse($result));
            }else{
                throw new UnifyOrderException($result['return_msg']);
            }
        });
    }

    /**
     * 自提订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeBuffetOrders(Request $request){
        $user = $this->user();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'  =>  $user['member_id']])
            ->first();

        if ($shopUser){
            $userId = $shopUser['id'];

            $sendTime = $request->all();

            $items = $this->orderRepository
                ->storeBuffetOrders($sendTime,  $userId);

            $shopEndHour = $this->shopRepository
                ->findwhere(['id'   =>  $userId])
                ->first();

            foreach ($items as $k => $v){
                $items[$k]['shop_end_hour'] = $shopEndHour['end_at'];

                $items[$k]['order_item_merchandises'] = $this->orderItemRepository
                    ->OrderItemMerchandises($v['id']);
            }

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
        $user = $this->user();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'   =>  $user['member_id']])
            ->first();

        if ($shopUser) {
            $userId     = $shopUser['id'];
            $sendTime   = $request->all();

            $items = $this->orderRepository
                ->storeSendOrders($sendTime,$userId);

            foreach ($items as $k => $v){
                $items[$k]['order_item_merchandises'] = $this->orderItemRepository
                    ->OrderItemMerchandises($v['id']);
            }

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
        $user   = $this->user();

        $customerId = $user['id'];

        $items = $this->orderRepository
            ->orders($status,   $customerId);

        foreach ($items as $k => $v){
            $items[$k]['order_item_merchandises'] = $this->orderItemRepository
                ->OrderItemMerchandises($v['id']);
        }

        return $this->response()
            ->paginator($items, new StatusOrdersTransformer());
    }

    /**
     * 销售订单汇总
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeOrdersSummary(Request $request){
        $user = $this->user();

        $shopUser = $this->shopRepository
            ->findWhere(['user_id'  =>  $user['member_id']])
            ->first();

        if ($shopUser) {
            $userId = $shopUser['id'];

            $request = $request->all();

            $items = $this->orderRepository
                ->storeOrdersSummary($request,  $userId);

            foreach ($items as $k => $v){
                    $reduce_cost = $this->cardRepository
                        ->findWhere(['card_id' => $v['card_id']])
                        ->first();

                    $items[$k]['reduce_cost'] = $reduce_cost ? $reduce_cost['card_info']['cash']['base_info']['title'] : '无';

                    $items[$k]['sell_point']  = '';

                    $items[$k]['order_item_merchandises'] = $this->orderItemRepository
                        ->OrderItemMerchandises($v['id']);
            }

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

        $items = $this->orderItemRepository
            ->findWhere(['order_id' => $id]);

        foreach ($items as $v) {
            $this->orderItemRepository
                ->update($status, $v['id']);
        }

        $item = $this->orderRepository
            ->update($status, $id);

        return $this->response(new JsonResponse(['confirm_status' => $item]));
    }

    /**
     * 确认订单
     * @param int $id
     * @return mixed
     */
    public function confirmOrder(int $id){
        $status = ['status' => Order::COMPLETED];

        $items = $this->orderItemRepository
            ->findWhere(['order_id'=>$id]);

        foreach ($items as $v){
            $this->orderItemRepository
                ->update($status,$v['id']);
        }

        $item = $this->orderRepository
            ->update($status, $id);

        return $this->response(new JsonResponse(['confirm_status' => $item['status']]));
    }

}