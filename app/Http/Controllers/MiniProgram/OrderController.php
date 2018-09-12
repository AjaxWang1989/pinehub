<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 18:44
 */

namespace App\Http\Controllers\MiniProgram;


use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\OrderRepository;
use App\Repositories\CardRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\MerchandiseRepository;
use App\Transformers\Mp\OrderTransformer;

class OrderController extends Controller
{
    protected $orderRepository = null;
    protected $userTicketRepository = null;
    protected $shoppingCartRepository = null;
    protected $merchandiseRepository = null;

    /**
     * OrderController constructor.
     * @param AppRepository $appRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param CardRepository $cardRepository
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param OrderRepository $orderRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,MerchandiseRepository $merchandiseRepository ,CardRepository $cardRepository,ShoppingCartRepository $shoppingCartRepository,OrderRepository $orderRepository ,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->orderRepository = $orderRepository;
        $this->cardRepository = $cardRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->merchandiseRepository = $merchandiseRepository;
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function createOrder(Request $request){
        $user = $this->user();
        $userId = $user ? $user['id'] : 1;
        $orders = $request->all();
        $orders['member_id'] = $userId;
        $cardRepository = $this->cardRepository->findWhere(['id'=>$orders['ticked_id']])->first();
        $orders['discount_amount'] = $cardRepository['card_info']['discount'];
        $ordersMerchandise = $this->orderRepository->create($orders);
        $shoppingCart = $this->shoppingCartRepository->findWhere(['user_id'=>$userId,'shop_id'=>$orders['store_id']]);
        $itemMerchandises = [];
        //组装购物车数据存入订单表中
        foreach ($shoppingCart as $k => $v) {
            $merchandises = $this->merchandiseRepository->findWhere(['id'=>$v['merchandise_id']])->first();
            $itemMerchandises[$k]['shop_id'] = $v['shop_id'];
            $itemMerchandises[$k]['member_id'] = $v['user_id'];
            $itemMerchandises[$k]['order_id'] = $ordersMerchandise['id'];
            $itemMerchandises[$k]['merchandise_id'] = $v['merchandise_id'];
            $itemMerchandises[$k]['name'] = $merchandises['name'];
            $itemMerchandises[$k]['main_image'] = $merchandises['main_image'];
            $itemMerchandises[$k]['origin_price'] = $merchandises['origin_price'];
            $itemMerchandises[$k]['sell_price'] = $merchandises['sell_price'];
            $itemMerchandises[$k]['cost_price'] = $merchandises['cost_price'];
            $itemMerchandises[$k]['quality'] = $v['quality'];
            $itemMerchandises[$k]['total_price'] = $v['amount'];
            $itemMerchandises[$k]['payment_price'] = $v['amount'];
            $itemMerchandises[$k]['status'] = 10;
        }
        $item = $this->orderRepository->insertMerchandise($itemMerchandises);
        return $this->response()->item($ordersMerchandise,new OrderTransformer());
    }
}