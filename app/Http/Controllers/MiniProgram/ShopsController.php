<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 15:46
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Shop;
use App\Repositories\ShopRepository;
use App\Repositories\AppRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShopMerchandiseRepository;
use App\Transformers\Mp\ShopPositionTransformer;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Http\Request;
use App\Transformers\Mp\StoreMerchandiseTransformer;
use App\Http\Response\JsonResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

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

    const SEND_BATCH_COLLECTION = [
        ['5:00', '6:00'],
        ['10:00', '11:00'],
        ['14:00', '15:00']
    ];

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
     * @param Request $request
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
     * @return ShopsController|\Dingo\Api\Http\Response\Factory|\Illuminate\Foundation\Application|\Laravel\Lumen\Application|mixed
     */
    public function storeSalesStatistics(Request $request){
        $user = $this->shopManager();
        /** @var Shop $shop */
        $shop = $this->shopRepository->findWhere(['user_id' => $user->id])->first();
        if ($shop){
            $unit = $request->input('statistics_unit', 'day');
            $startAt = null;
            $now = $endAt  = Carbon::now();;
            $limit = 0;
            //没有值的话默认给当前截止时间
            $statisticsArrayCount = 0;
            if ($unit === 'hour') {
                $startAt = $now->startOfDay();
                $statisticsArrayCount = $now->hour;
                $limit = 24;
            }else if($unit === 'day') {
                $startAt = $now->startOfMonth();
                $limit = $now->daysInMonth;
                $statisticsArrayCount = $now->day;
            }

            //查询出截止当前时间,星期,天数每条数据的金额总和
            $orders = $this->orderRepository->orderStatistics($shop->id, $unit, $startAt, $endAt, $limit);
            $item = $this->orderRepository->buildOrderStatisticData($orders, $unit, $statisticsArrayCount);

            //销售排行额客户
            $consumptionRanking = $this->orderItemRepository->consumptionRanking($shop->id, $startAt, $endAt);
            //销售排行额货品
            $merchandiseSalesRanking = $this->orderItemRepository->merchandiseSalesRanking($shop->id, $startAt, $endAt);

            $item['sell_point'] = 0;
            $item['consumption_ranking'] = $consumptionRanking;
            $item['merchandise_sales_ranking'] = $merchandiseSalesRanking;
            return $this->response(new JsonResponse($item));
        }else{
            throw new ModelNotFoundException('您没有店铺无法查询店铺统计接口');
        }
    }

    /**
     * 我的店铺
     * @return mixed
     */
    public function storeInfo(){
        $now = $endAt = Carbon::now();
        $startAt = $endAt->startOfWeek();
        $user = $this->shopManager();
        try{
            /** @var Shop $shop */
            $shop = $this->shopRepository->findWhere(['user_id' => $user->id])->first();
            $orders = $this->orderRepository->orderStatistics($shop->id, 'week', $startAt, $endAt, 7);
            //今日用户购买数量
            $todayBuyNum = $orders->where('paid_at', '>=', $now->startOfDay())
                ->where('paid_at', '<', $endAt)
                ->sum('order_count');
            //本周用户购买数量
            $weekBuyNum = $orders->sum('order_count');
            //今日营业额
            $todaySellAmount = $orders->where('paid_at', '>=', $now->startOfDay())
                ->where('paid_at', '<', $endAt)
                ->sum('total_payment_amount');
            //本周营业额
            $weekSellAmount = $orders->sum('total_payment_amount');

            //组装本周购买的用户
            $orderCountStatistics = [];
            $orderPaymentAmountStatistics = [];
            for ($i=0; $i < 7 ; $i++){
                $orderCountStatistics[$i] = 0;
                $orderPaymentAmountStatistics[$i] = 0;
                $orders->map(function ($order) use($i, $orderCountStatistics, $orderPaymentAmountStatistics) {
                    if($order['week'] == $i + 1){
                        $orderCountStatistics[$i] = $order['order_count'];
                        $orderPaymentAmountStatistics[$i] = $order['total_payment_amount'];
                    }
                });
            }

            $shop['today_buy_num'] = $todayBuyNum;
            $shop['week_buy_num'] = $weekBuyNum;
            $shop['today_sell_amount'] = $todaySellAmount;
            $shop['week_sell_amount'] = $weekSellAmount;
            $shop['order_count_statistics'] = $orderCountStatistics;
            $shop['order_payment_amount_statistics'] = $orderCountStatistics;
            return $this->response(new JsonResponse($shop));

        }catch (\Exception $exception) {
            Log::info('exception', $exception->getTrace());
            throw new ModelNotFoundException('你不是店主无法访问接口');
        }
    }

    /**
     * 今日下单搜索
     * @param int $shopId
     * @param Request $request
     * @return ShopsController|\Dingo\Api\Http\Response|\Dingo\Api\Http\Response\Factory|\Illuminate\Foundation\Application|\Laravel\Lumen\Application|mixed
     */
    public function searchShopMerchandises(int $shopId ,Request $request){
        if ($request['name']){
            $merchandises = $this->merchandiseRepository->findMerchandises($request['name']);
            $merchandisesIds = [];
            foreach ($merchandises as $k => $v){
                $merchandisesIds[$k] = $v['id'];
            }
            $items = $this->shopMerchandiseRepository->shopMerchandises($shopId, $merchandisesIds);
            return $this->response->paginator($items,new StoreMerchandiseTransformer);
        }else{
            throw new ValidationHttpException('搜索的商品名字不能为空');
        }
    }
}