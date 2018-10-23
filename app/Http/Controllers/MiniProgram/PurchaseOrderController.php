<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:38
 */

namespace App\Http\Controllers\MiniProgram;
use App\Entities\OrderPurchaseItems;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\StorePurchaseOrdersRepository;
use App\Repositories\OrderPurchaseItemsRepository;
use App\Repositories\ShopMerchandiseRepository;
use App\Repositories\MerchandiseCategoryRepository;
use App\Transformers\Mp\StorePurchaseOrdersTransformer;
use App\Transformers\Mp\StoreCodeOrderMerchandiseUpTransformer;
use App\Repositories\ShopRepository;
use App\Http\Response\JsonResponse;


class PurchaseOrderController extends Controller
{
    protected $storePurchaseOrdersRepository = null;
    protected $orderPurchaseItemsRepository  = null;
    protected $shopMerchandiseRepository     = null;
    protected $merchandiseCategoryRepository = null;
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
    public function __construct(AppRepository $appRepository,ShopRepository $shopRepository,MerchandiseCategoryRepository $merchandiseCategoryRepository,ShopMerchandiseRepository $shopMerchandiseRepository,StorePurchaseOrdersRepository $storePurchaseOrdersRepository ,OrderPurchaseItemsRepository $orderPurchaseItemsRepository,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->storePurchaseOrdersRepository = $storePurchaseOrdersRepository;
        $this->orderPurchaseItemsRepository  = $orderPurchaseItemsRepository;
        $this->shopMerchandiseRepository     = $shopMerchandiseRepository;
        $this->merchandiseCategoryRepository = $merchandiseCategoryRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * 进货统计
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storePurchaseStatistics(Request $request)

    {
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $request = $request->all();
            $storePurchaseStatisticsAmount = $this->storePurchaseOrdersRepository->storePurchaseStatistics($request,$userId);
            $storeOrders = $this->storePurchaseOrdersRepository->storeOrders($request,$userId);
            return $this->response()->paginator($storeOrders,new StorePurchaseOrdersTransformer)->addMeta('total_amount',
                $storePurchaseStatisticsAmount['total_amount']);
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 物流进货扫码
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeCodeOrderMerchandiseUp (Request $request)
    {
        $request = $request->all();
        $storePurchaseMessage = $this->storePurchaseOrdersRepository->findWhere(['code'=>$request['code']])->first();
        $orderPurchaseItems = $this->orderPurchaseItemsRepository->orderPurchaseItems($storePurchaseMessage['id'],$storePurchaseMessage['shop_id']);
        foreach ($orderPurchaseItems as $v){
            $shopMerchandise = $this->shopMerchandiseRepository->findWhere(['shop_id'=>$v['shop_id'],'merchandise_id'=>$v['merchandise_id']])->first();
            if ($shopMerchandise){
                    $data['stock_num'] = $shopMerchandise['stock_num'] + $v['quality'];
                    $this->shopMerchandiseRepository->update($data,$shopMerchandise['id']);
                    $this->orderPurchaseItemsRepository->update(['status'=>OrderPurchaseItems::MAKE_SURE],$v['id']);
            }else{
                $merchandiseCategory = $this->merchandiseCategoryRepository->findWhere(['merchandise_id'=>$v['merchandise_id']])->first();
                $data = ['shop_id'=>$v['shop_id'],'merchandise_id'=>$v['merchandise_id'],'category_id'=>$merchandiseCategory['id'],'stock_num'=>$v['quality']];
                $this->shopMerchandiseRepository->create($data);
                $this->orderPurchaseItemsRepository->update(['status'=>OrderPurchaseItems::MAKE_SURE],$v['id']);
            }
        }
        $item = $this->storePurchaseOrdersRepository->update(['status'=>OrderPurchaseItems::MAKE_SURE],$storePurchaseMessage['id']);
        return $this->response()->item($item,new StoreCodeOrderMerchandiseUpTransformer());
    }
}