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
use App\Transformers\Mp\ShopPositionTransformer;
use Dingo\Api\Http\Request;
use App\Transformers\Mp\StoreSellStatisticsTransformer;
use App\Http\Response\JsonResponse;

class ShopsController extends Controller
{
    protected  $shopRepository = null;
    protected  $orderItemRepository = null;
    protected  $orderRepository = null;
    /**
     * ShopsController constructor.
     * @param ShopRepository $shopRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShopRepository $shopRepository,OrderItemRepository $orderItemRepository ,OrderRepository $orderRepository ,AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->shopRepository = $shopRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
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
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function nearbyStores(Request $request){
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $item = $this->shopRepository->nearBy($lng,$lat);
        return $this->response()->paginator($item, new ShopPositionTransformer());
    }

    /**
     * 销售统计
     * @param Request $request
     */
    public function storeSellStatistics(Request $request){
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $request = $request->all();
            $orderStatistics = $this->orderRepository->orderStatistics($request,$userId);
            $orderDateHigh  = $this->orderRepository->orderDateHigh($request,$userId);
            $statics = [];
            for ($i=0; $i < $orderDateHigh[$request['date']] ; $i++){
                $statics[$i] = 0;
                foreach ($orderStatistics as $k=>  $v) {
                    if($v[$request['date']] == $i + 1){
                        $statics[$i] = $v['total_amount'];
                    }
                }
            }
            $item['statics'] = $statics;
            $bookPaymentAmount = $this->orderRepository->bookPaymentAmount($request,$userId);
            $sitePaymentAmount = $this->orderRepository->sitePaymentAmount($request,$userId);
            $sellMerchandiseNum = $this->orderItemRepository->sellMerchandiseNum($request,$userId);
            $sellOrderNum = $this->orderRepository->sellOrderNum($request,$userId);
            $sellTop = $this->orderItemRepository->sellTop($request,$userId);
            $sellMerchandiseTop = $this->orderItemRepository->sellMerchandiseTop($request,$userId);
            $item['reservation_order_amount'] = $bookPaymentAmount['total_amount'];
            $item['store_order_amount'] = $sitePaymentAmount['total_amount'];
            $item['merchandise_num'] = $sellMerchandiseNum['total_amount'];
            $item['sell_point'] = '';
            $item['order_num'] = count($sellOrderNum);
            $item['sell_top'] = $sellTop;
            $item['merchandise_top'] = $sellMerchandiseTop;
            return $this->response()->array($item,new StoreSellStatisticsTransformer());
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
        $todayBuyNum = $this->orderRepository->todayBuyNum($request);
        $weekBuyNum = $this->orderRepository->weekBuyNum($request);
        $todaySellAmount = $this->orderRepository->todaySellAmount($request);
        $weekSellAmount = $this->orderRepository->weekSellAmount($request);
        $weekStatistics = $this->orderRepository->weekStatistics($request);

        $weekBuyNumStatics = [];
        for ($i=0; $i < 7 ; $i++){
            $weekBuyNumStatics[$i] = 0;
            foreach ($weekStatistics as $k=>  $v) {
                if($v['week'] == $i + 1){
                    $weekBuyNumStatics[$i] = $v['buy_num'];
                }
            }
        }

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

        $item['today_buy_num'] = count($todayBuyNum);
        $item['week_buy_num'] = count($weekBuyNum);
        $item['today_sell_amount'] = $todaySellAmount['total_amount'];
        $item['week_sell_amount'] = $weekSellAmount['total_amount'];
        $item['buy_mum'] = $weekBuyNumStatics;
        $item['sell_amount'] = $weekBuyNumAmount;
        return $this->response()->array($item,new StoreSellStatisticsTransformer());
    }

}