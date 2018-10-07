<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 18:44
 */

namespace App\Http\Controllers\MiniProgram;


use App\Entities\Order;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\OrderRepository;
use App\Repositories\CardRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\OrderItemRepository;
use App\Transformers\Mp\OrderTransformer;
use App\Transformers\Mp\OrderStoreBuffetTransformer;
use App\Transformers\Mp\OrderStoreSendTransformer;
use App\Transformers\Mp\StatusOrdersTransformer;
use App\Transformers\Mp\StoreOrdersSummaryTransformer;
use App\Repositories\ShopRepository;
use App\Http\Response\JsonResponse;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    protected $orderRepository = null;
    protected $userTicketRepository = null;
    protected $shoppingCartRepository = null;
    protected $merchandiseRepository = null;
    protected $shopRepository = null;
    protected $orderItemRepository = null;

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
    public function __construct(AppRepository $appRepository,OrderItemRepository $orderItemRepository ,ShopRepository $shopRepository,MerchandiseRepository $merchandiseRepository ,CardRepository $cardRepository,ShoppingCartRepository $shoppingCartRepository,OrderRepository $orderRepository ,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->orderRepository = $orderRepository;
        $this->cardRepository = $cardRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shopRepository = $shopRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * 创建订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function createOrder(Request $request)
    {
        $accessToken = $request->input('access_token', null);
        $appId = Cache::get($accessToken);
        $user = $this->user();
        $orders = $request->all();
        $orders['app_id'] = $appId;
        $orders['member_id'] = $user['member_id'];
        $orders['customer_id'] = $user['id'];
        $orders['open_id']  = $user['open_id'];
        $cardRepository = $this->cardRepository->findWhere(['card_id'=>$orders['card_id']])->first();
        $orders['discount_amount'] = $cardRepository ? $cardRepository['card_info']['cash']['reduce_cost']/100 : '';
        $orders['card_id'] = $cardRepository['card_id'];
        $orders['shop_id'] = $orders['store_id'];
        $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']])->sum('amount');
        $shoppingCartMerchandiseNum = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']])->sum('quality');
        $orders['merchandise_num'] = $shoppingCartMerchandiseNum;
        $orders['total_amount'] = $shoppingCartAmount;
        $orders['status'] = Order::WAIT;
        $orders['years'] = date('Y',time());
        $orders['month'] = date('d',time());
        $orders['week']  = date('w',time()) ==0 ? 7 : date('w',time());
        $orders['hour']  = date('H',time());
        $ordersMerchandise = $this->orderRepository->create($orders);
        $shoppingCart = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']]);
        $itemMerchandises = [];
        //组装购物车数据存入订单表中
        foreach ($shoppingCart as $k => $v) {
            $merchandises = $this->merchandiseRepository->findWhere(['id'=>$v['merchandise_id']])->first();
            $itemMerchandises[$k]['app_id'] = $appId;
            $itemMerchandises[$k]['shop_id'] = $v['shop_id'];
            $itemMerchandises[$k]['member_id'] = $v['member_id'];
            $itemMerchandises[$k]['customer_id'] = $v['customer_id'];
            $itemMerchandises[$k]['order_id'] = $ordersMerchandise['id'];
            $itemMerchandises[$k]['merchandise_id'] = $v['merchandise_id'];
            $itemMerchandises[$k]['name'] = $merchandises['name'];
            $itemMerchandises[$k]['main_image'] = $merchandises['main_image'];
            $itemMerchandises[$k]['origin_price'] = $merchandises['origin_price'];
            $itemMerchandises[$k]['sell_price'] = $merchandises['sell_price'];
            $itemMerchandises[$k]['cost_price'] = $merchandises['cost_price'];
            $itemMerchandises[$k]['quality'] = $v['quality'];
            $itemMerchandises[$k]['total_amount'] = $v['amount'];
            $itemMerchandises[$k]['status'] = 10;
        }
        $this->orderRepository->insertMerchandise($itemMerchandises);
        return $this->response()->item($ordersMerchandise,new OrderTransformer());
    }

    /**
     * 自提订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeBuffetOrders(Request $request){
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $sendTime = $request->all();
            $items = $this->orderRepository->storeBuffetOrders($sendTime,$userId);
            $shopEndHour = $this->shopRepository->findwhere(['id'=>$userId])->first();
            foreach ($items as $k => $v){
                $items[$k]['shop_end_hour'] = $shopEndHour['end_at'];
                $items[$k]['order_item_merchandises'] = $this->orderItemRepository->OrderItemMerchandises($v['id']);
            }
            return $this->response()->paginator($items,new OrderStoreBuffetTransformer());
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
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser) {
            $userId = $shopUser['id'];
            $sendTime = $request->all();
            $items = $this->orderRepository->storeSendOrders($sendTime,$userId);
            foreach ($items as $k => $v){
                $items[$k]['order_item_merchandises'] = $this->orderItemRepository->OrderItemMerchandises($v['id']);
            }
            return $this->response()->paginator($items,new OrderStoreSendTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 所有订单信息
     * @param string $status
     *
     */

    public function orders(string  $status){
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $items = $this->orderRepository->allOrders($status,$userId);
            foreach ($items as $k => $v){
                $items[$k]['order_item_merchandises'] = $this->orderItemRepository->OrderItemMerchandises($v['id']);
            }
            return $this->response()->paginator($items,new StatusOrdersTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 销售订单汇总
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeOrdersSummary(Request $request){
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $request = $request->all();
            $items = $this->orderRepository->storeOrdersSummary($request,$userId);
            foreach ($items as $k => $v){
                    $reduce_cost= $this->cardRepository->findWhere(['card_id'=>$v['card_id']])->first();
                    $items[$k]['reduce_cost'] = $reduce_cost ? $reduce_cost['card_info']['cash']['base_info']['title'] : '无';
                    $items[$k]['sell_point'] = '';
                    $items[$k]['order_item_merchandises'] = $this->orderItemRepository->OrderItemMerchandises($v['id']);
            }
            return $this->response()->paginator($items,new StoreOrdersSummaryTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

}