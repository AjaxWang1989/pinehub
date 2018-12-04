<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:38
 */

namespace App\Http\Controllers\MiniProgram;
use App\Entities\OrderPurchaseItems;
use App\Entities\Shop;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\StorePurchaseOrdersRepository;
use App\Repositories\OrderPurchaseItemsRepository;
use App\Repositories\ShopMerchandiseRepository;
use App\Repositories\MerchandiseCategoryRepository;
use App\Transformers\Mp\StorePurchaseOrdersTransformer;
use App\Transformers\Mp\StoreCodeOrderMerchandiseUpTransformer;
use App\Repositories\ShopRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;


class PurchaseOrderController extends Controller
{
    /**
     * @var StorePurchaseOrdersRepository|null
     */
    protected $storePurchaseOrdersRepository = null;

    /**
     * @var OrderPurchaseItemsRepository|null
     */
    protected $orderPurchaseItemsRepository  = null;

    /**
     * @var ShopMerchandiseRepository|null
     */
    protected $shopMerchandiseRepository     = null;

    /**
     * @var MerchandiseCategoryRepository|null
     */
    protected $merchandiseCategoryRepository = null;

    /**
     * @var ShopRepository|null
     */
    protected  $shopRepository = null;

    /**
     * PurchaseOrderController constructor.
     * @param AppRepository $appRepository
     * @param ShopRepository $shopRepository
     * @param MerchandiseCategoryRepository $merchandiseCategoryRepository
     * @param ShopMerchandiseRepository $shopMerchandiseRepository
     * @param StorePurchaseOrdersRepository $storePurchaseOrdersRepository
     * @param OrderPurchaseItemsRepository $orderPurchaseItemsRepository
     * @param Request $request
     */
    public function __construct(AppRepository $appRepository,
                                ShopRepository $shopRepository,
                                MerchandiseCategoryRepository $merchandiseCategoryRepository,
                                ShopMerchandiseRepository $shopMerchandiseRepository,
                                StorePurchaseOrdersRepository $storePurchaseOrdersRepository ,
                                OrderPurchaseItemsRepository $orderPurchaseItemsRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->appRepository                 = $appRepository;
        $this->storePurchaseOrdersRepository = $storePurchaseOrdersRepository;
        $this->orderPurchaseItemsRepository  = $orderPurchaseItemsRepository;
        $this->shopMerchandiseRepository     = $shopMerchandiseRepository;
        $this->merchandiseCategoryRepository = $merchandiseCategoryRepository;
        $this->shopRepository                = $shopRepository;
    }

    /**
     * 进货统计
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storePurchaseStatistics(Request $request)
    {
        $user = $this->mpUser();

        /** @var Shop $shop */
        $shop = $this->shopRepository->findWhere(['user_id' => $user['member_id']])->first();
        if ($shop) {
            $userId = $shop->id;
            $startAt = null;
            $endAt = null;
            $date = $request->input('date');
            $now = Carbon::now();
            if ($date == 'hour') {
                $startAt = $now->startOfDay();
                $endAt  = $now;
            } else if($date == 'week') {
                $startAt = $now->startOfWeek();
                $endAt  = $now;
            } else if($date == 'month') {
                $startAt = $now->startOfMonth();
                $endAt  = $now;
            }
            //进货订单总金额
            //进货订单的总订单数
            $storeOrders = $this->storePurchaseOrdersRepository->storeOrders($startAt, $endAt,$userId);
            $storePurchaseStatisticsAmount = with($storeOrders, function (Collection $orders) {
                return $orders->sum('payment_amount');
            });
            return $this->response()->paginator($storeOrders, new StorePurchaseOrdersTransformer)->addMeta('total_amount',
                $storePurchaseStatisticsAmount);
        } else {
            throw new ModelNotFoundException('你不是店主没有权限访问此接口');
        }
    }

    /**
     * 物流进货扫码
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeCodeOrderMerchandiseUp (Request $request)
    {
        $request = $request->all();
        //根据code码获取此code码下面的一条主订单信息
        $storePurchaseMessage = $this->storePurchaseOrdersRepository->findWhere([
            'code'=>$request['code']
        ])->first();

        //根据主订单id获取此主订单下所有字订单信息
        $orderPurchaseItems = $this->orderPurchaseItemsRepository->orderPurchaseItems(
            $storePurchaseMessage['id'],
            $storePurchaseMessage['shop_id']
        );

        foreach ($orderPurchaseItems as $v){
            //根据店铺id和商品id查询店铺此商品的库存
            $shopMerchandise = $this->shopMerchandiseRepository->findWhere([
                'shop_id'=>$v['shop_id'],
                'merchandise_id'=>$v['merchandise_id']
            ])->first();

            if ($shopMerchandise){
                    $data['stock_num'] = $shopMerchandise['stock_num'] + $v['quality'];
                    $this->shopMerchandiseRepository->update($data,$shopMerchandise['id']);
                    $this->orderPurchaseItemsRepository->update(['status'=>OrderPurchaseItems::MAKE_SURE],$v['id']);
            }else{
                //查询此商品属于哪个分类
                $merchandiseCategory = $this->merchandiseCategoryRepository->findWhere([
                    'merchandise_id'=>$v['merchandise_id']
                ])->first();

                //组装数据
                $data = [
                    'shop_id'=>$v['shop_id'],
                    'merchandise_id'=>$v['merchandise_id'],
                    'category_id'=>$merchandiseCategory['id'],
                    'stock_num'=>$v['quality']
                ];

                //生成一条店铺此商品的新库存
                $this->shopMerchandiseRepository->create($data);
                $this->orderPurchaseItemsRepository->update(['status'=>OrderPurchaseItems::MAKE_SURE],$v['id']);
            }
        }
        //更改主订单状态
        $item = $this->storePurchaseOrdersRepository->update([
            'status'=>OrderPurchaseItems::MAKE_SURE],
            $storePurchaseMessage['id']
        );
        return $this->response()->item($item,new StoreCodeOrderMerchandiseUpTransformer());
    }
}