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
use App\Transformers\Mp\OrderTransformer;
use App\Transformers\Mp\OrderStoreBuffetTransformer;
use App\Transformers\Mp\OrderStoreSendTransformer;
use App\Transformers\Mp\StatusOrdersTransformer;
use App\Transformers\Mp\StoreOrdersSummaryTransformer;
use App\Repositories\ShopRepository;
use App\Http\Response\JsonResponse;

class OrderController extends Controller
{
    protected $orderRepository = null;
    protected $userTicketRepository = null;
    protected $shoppingCartRepository = null;
    protected $merchandiseRepository = null;
    protected  $shopRepository = null;

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
    public function __construct(AppRepository $appRepository,ShopRepository $shopRepository,MerchandiseRepository $merchandiseRepository ,CardRepository $cardRepository,ShoppingCartRepository $shoppingCartRepository,OrderRepository $orderRepository ,Request $request)
    {
        date_default_timezone_set("Asia/Shanghai");
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->orderRepository = $orderRepository;
        $this->cardRepository = $cardRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * 创建订单
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function createOrder(Request $request)
    {
        $user = $this->user();
        $orders = $request->all();
        $orders['member_id'] = $user['member_id'];
        $orders['customer_id'] = $user['id'];
        $orders['open_id']  = $user['open_id'];
        $cardRepository = $this->cardRepository->findWhere(['id'=>$orders['ticked_id']])->first();
        $orders['discount_amount'] = $cardRepository ? $cardRepository['card_info']['discount'] : '';
        $orders['shop_id'] = $orders['store_id'];
        $shoppingCartAmount = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']])->sum('amount');
        $shoppingCartMerchandiseNum = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']])->sum('quality');
        $orders['merchandise_num'] = $shoppingCartMerchandiseNum;
        $orders['total_amount'] = $shoppingCartAmount;
        $orders['status'] = Order::WAIT;
        $orders['years'] = date('Y',time());
        $orders['month'] = date('m',time());
        $orders['week']  = date('w',time()) ==0 ? 7 : date('w',time());
        $orders['hour']  = date('H',time());
        $ordersMerchandise = $this->orderRepository->create($orders);
        $shoppingCart = $this->shoppingCartRepository->findWhere(['customer_id'=>$user['id'],'shop_id'=>$orders['store_id']]);
        $itemMerchandises = [];
        //组装购物车数据存入订单表中
        foreach ($shoppingCart as $k => $v) {
            $merchandises = $this->merchandiseRepository->findWhere(['id'=>$v['merchandise_id']])->first();
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
            $item = $this->orderRepository->storeBuffetOrders($sendTime,$userId);
            return $this->response()->paginator($item,new OrderStoreBuffetTransformer());
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
            if (empty($sendTime)){
                $sendTime['send_start_time'] = date('Y-m-d 00:00:00',time());
                $sendTime['send_end_time'] = date('Y-m-d 23:59:59',time());
            }
            $item = $this->orderRepository->storeSendOrders($sendTime,$userId);
            return $this->response()->paginator($item,new OrderStoreSendTransformer());
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
            $item = $this->orderRepository->allOrders($status,$userId);
            return $this->response()->paginator($item,new StatusOrdersTransformer());
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
            $item = $this->orderRepository->storeOrdersSummary($request,$userId);
            return $this->response()->paginator($item,new StoreOrdersSummaryTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

}