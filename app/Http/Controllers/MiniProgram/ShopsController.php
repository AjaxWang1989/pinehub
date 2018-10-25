<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 15:46
 */

namespace App\Http\Controllers\MiniProgram;

use App\Repositories\ShopRepository;
use App\Repositories\AppRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShopMerchandiseRepository;
use App\Transformers\Mp\ShopPositionTransformer;
use Dingo\Api\Http\Request;
use App\Transformers\Mp\StoreSellStatisticsTransformer;
use App\Transformers\Mp\StoreMerchandiseTransformer;
use App\Http\Response\JsonResponse;

class ShopsController extends Controller
{
    /**
     * @var ShopRepository|null
     */
    protected  $shopRepository = null;

    /**
     * @var OrderItemRepository|null
     */
    protected  $orderItemRepository = null;

    /**
     * @var OrderRepository|null
     */
    protected  $orderRepository = null;

    /**
     * @var MerchandiseRepository|null
     */
    protected  $merchandiseRepository = null;

    /**
     * @var ShopMerchandiseRepository|null
     */
    protected  $shopMerchandiseRepository = null;

    /**
     * ShopsController constructor.
     * @param ShopRepository $shopRepository
     * @param ShopMerchandiseRepository $shopMerchandiseRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param OrderItemRepository $orderItemRepository
     * @param OrderRepository $orderRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShopRepository $shopRepository,
                                ShopMerchandiseRepository $shopMerchandiseRepository,
                                MerchandiseRepository $merchandiseRepository,
                                OrderItemRepository $orderItemRepository ,
                                OrderRepository $orderRepository ,
                                AppRepository $appRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->shopRepository            = $shopRepository;
        $this->orderItemRepository       = $orderItemRepository;
        $this->orderRepository           = $orderRepository;
        $this->merchandiseRepository     = $merchandiseRepository;
        $this->shopMerchandiseRepository = $shopMerchandiseRepository;
    }

    /**
     * 获取今日下单店铺
     * @param string $id
     * @return \Dingo\Api\Http\Response
     */
    public function nearestStore(Request $request){
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $item = $this->shopRepository->nearest($lng,$lat);
        return $this->response()->item($item, new ShopPositionTransformer());
    }

    /**
     * 获取附近所有店铺地址
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function nearbyStores(Request $request){
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $items= $this->shopRepository->nearBy($lng,$lat);
        return $this->response()->paginator($items, new ShopPositionTransformer());
    }

    /**
     * 销售统计
     * @param Request $request
     */
    public function storeSellStatistics(Request $request){
        $user = $this->mpUser();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $request = $request->all();
            //查询出截止当前时间,星期,天数每条数据的金额总和
            $orderStatistics = $this->orderRepository->orderStatistics($request,$userId);
            //查询出截止当前时间,星期,天数的最后一条数据
            $orderDateHigh  = $this->orderRepository->orderDateHigh($request,$userId);

            //没有值的话默认给当前截止时间
            if (empty($orderDateHigh) && $request['date'] == 'hour'){

                $orderDateHigh[$request['date']] = date('H',time());

            }elseif (empty($orderDateHigh) && $request['date'] == 'week'){

                $orderDateHigh[$request['date']] = date('w', time()) === 0 ? 7 : date('w', time());

            }elseif (empty($orderDateHigh) && $request['date'] == 'month'){

                $orderDateHigh[$request['date']] = date('d', time());

            }
            $statics = [ ];
            //循环组装当前截止时间的数据
            for ($i=0; $i < $orderDateHigh[$request['date']] ; $i++){
                $statics[$i] = 0;
                foreach ($orderStatistics as $k=>  $v) {
                    if($v[$request['date']] == $i + 1){
                        $statics[$i] = $v['total_amount'];
                    }
                }
            }
            $items['statics'] = $statics;
            //预定产品金额总和
            $bookPaymentAmount = $this->orderRepository->bookPaymentAmount($request,$userId);
            //站点产品金额总和
            $sitePaymentAmount = $this->orderRepository->sitePaymentAmount($request,$userId);
            //销售单品数量总和
            $sellMerchandiseNum = $this->orderItemRepository->sellMerchandiseNum($request,$userId);
            //销售笔数
            $sellOrderNum = $this->orderRepository->sellOrderNum($request,$userId);
            //销售排行额客户
            $sellTop = $this->orderItemRepository->sellTop($request,$userId);
            //销售排行额货品
            $sellMerchandiseTop = $this->orderItemRepository->sellMerchandiseTop($request,$userId);

            $items['order_amount'] = $bookPaymentAmount['total_amount'] + $sitePaymentAmount['total_amount'];
            $items['reservation_order_amount'] = $bookPaymentAmount['total_amount'];
            $items['store_order_amount'] = $sitePaymentAmount['total_amount'];
            $items['merchandise_num'] = $sellMerchandiseNum['total_amount'];
            $items['sell_point'] = '';
            $items['order_num'] = count($sellOrderNum);
            $items['sell_top'] = $sellTop;
            $items['merchandise_top'] = $sellMerchandiseTop;
            return $this->response()->array($items,new StoreSellStatisticsTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 我的店铺
     * @param Request $request
     * @return mixed
     */
    public function storeStatistics(Request $request){
        $request = $request->all();
        //今日用户购买数量
        $todayBuyNum = $this->orderRepository->todayBuyNum($request);
        //本周用户购买数量
        $weekBuyNum = $this->orderRepository->weekBuyNum($request);
        //今日营业额
        $todaySellAmount = $this->orderRepository->todaySellAmount($request);
        //本周营业额
        $weekSellAmount = $this->orderRepository->weekSellAmount($request);
        //本周购买总用户和总数额
        $weekStatistics = $this->orderRepository->weekStatistics($request);

        //组装本周购买的用户
        $weekBuyNumStatics = [];
        for ($i=0; $i < 7 ; $i++){
            $weekBuyNumStatics[$i] = 0;
            foreach ($weekStatistics as $k=>  $v) {
                if($v['week'] == $i + 1){
                    $weekBuyNumStatics[$i] = $v['buy_num'];
                }
            }
        }

        //组装本周购买的金额
        $sellAmount = $this->orderRepository->sellAmount($request);
        $weekBuyNumAmount = [];
        for ($i=0; $i < 7 ; $i++){
            $weekBuyNumAmount[$i] = 0;
            foreach ($sellAmount as $k=>  $v) {
                if($v['week'] == $i + 1){
                    $weekBuyNumAmount[$i] = $v['total_amount'];
                }
            }
        }

        $items['today_buy_num'] = count($todayBuyNum);
        $items['week_buy_num'] = count($weekBuyNum);
        $items['today_sell_amount'] = $todaySellAmount['total_amount'];
        $items['week_sell_amount'] = $weekSellAmount['total_amount'];
        $items['buy_mum'] = $weekBuyNumStatics;
        $items['sell_amount'] = $weekBuyNumAmount;
        return $this->response()->array($items,new StoreSellStatisticsTransformer());
    }

    /**
     * 今日下单搜索
     * @param int $shopId
     * @param Request $request
     */
    public function searchShopMerchandises(int $shopId ,Request $request){
        if ($request['name']){
            $merchandises = $this->merchandiseRepository->findMerchandises($request['name']);
            $merchandisesIds = [];
            foreach ($merchandises as $k => $v){
                $merchandisesIds[$k] = $v['id'];
            }
            $items = $this->shopMerchandiseRepository->shopMerchandises($shopId,$merchandisesIds);
            return $this->response->paginator($items,new StoreMerchandiseTransformer);
        }else{
            return $this->response(new JsonResponse(['message' => '搜索的商品名字不能为空']));
        }
    }
}