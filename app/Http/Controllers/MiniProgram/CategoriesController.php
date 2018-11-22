<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:27
 */

namespace App\Http\Controllers\MiniProgram;
use App\Entities\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseCategoryRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ShopMerchandiseStockModifyRepository;
use Dingo\Api\Http\Request;
use App\Http\Requests\MiniProgram\StoreStockUpdateRequest;
use App\Http\Requests\MiniProgram\StoreStockListRequest;
use App\Transformers\Mp\CategoriesTransformer;
use App\Transformers\Mp\MerchandisesTransformer;
use App\Transformers\Mp\StoreMerchandiseTransformer;
use App\Transformers\Mp\StoreCategoriesTransformer;
use App\Transformers\Mp\StoreStockStatisticsTransformer;
use App\Transformers\Mp\ShopMerchandiseStockModifyTransformer;
use App\Transformers\Mp\ReserveSearchMerchandisesTransformer;
use App\Repositories\ShopMerchandiseRepository;
use App\Repositories\MerchandiseRepository;
use App\Http\Response\JsonResponse;


class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository|null
     */
    protected  $categoryRepository = null;

    /**
     * @var MerchandiseCategoryRepository|null
     */
    protected  $merchandiseCategoryRepository = null;

    /**
     * @var ShopMerchandiseRepository|null
     */
    protected  $shopMerchandiseRepository = null;

    /**
     * @var null
     */
    protected  $shopMerchandiseStockModifyRepository = null;

    /**
     * @var MerchandiseRepository|null
     */
    protected  $merchandiseRepository = null;

    /**
     * @var ShopRepository|null
     */
    protected  $shopRepository = null;
    private $merchandiseStockModifyRepository;

    /**
     * CategoriesController constructor.
     * @param MerchandiseRepository $merchandiseRepository
     * @param ShopRepository $shopRepository
     * @param ShopMerchandiseStockModifyRepository $merchandiseStockModifyRepository
     * @param CategoryRepository $categoryRepository
     * @param MerchandiseCategoryRepository $merchandiseCategoryRepository
     * @param ShopMerchandiseRepository $shopMerchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(MerchandiseRepository $merchandiseRepository,
                                ShopRepository $shopRepository,
                                ShopMerchandiseStockModifyRepository $merchandiseStockModifyRepository,
                                CategoryRepository $categoryRepository,
                                MerchandiseCategoryRepository $merchandiseCategoryRepository,
                                ShopMerchandiseRepository $shopMerchandiseRepository,
                                AppRepository $appRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->categoryRepository               = $categoryRepository;
        $this->merchandiseCategoryRepository    = $merchandiseCategoryRepository;
        $this->shopMerchandiseRepository        = $shopMerchandiseRepository;
        $this->merchandiseStockModifyRepository = $merchandiseStockModifyRepository;
        $this->merchandiseRepository            = $merchandiseRepository;
        $this->shopRepository                   = $shopRepository;
    }
    /*
     * 获取预定商城所有分类
     */
    public function categories()
    {
        $items = $this->categoryRepository->scopeQuery(function (Category $category) {
            return $category->has('merchandises');
        })->paginate();
        return $this->response()->paginator($items,new CategoriesTransformer);
    }
    /*
     * 根据分类获取所有商品信息
     * $param int $id
     */

    public function categoriesMerchandises(int $id)
    {
      $items = $this->merchandiseCategoryRepository->merchandises($id);
      return $this->response()->paginator($items,new MerchandisesTransformer());
    }

    /*
     * 一个店铺下的所有分类
     * @param int $id
     */

    public function storeCategories(int $id)
    {
        $items = $this->shopMerchandiseRepository->storeCategories($id);
        return $this->response()->paginator($items,new StoreCategoriesTransformer);
    }

    /**
     * 一个店铺分类下的商品信息
     * @param int $id
     * @param int $categoryId
     */
    public function storeCategoryMerchandise(int $id ,int $categoryId)
    {
        $items = $this->shopMerchandiseRepository->storeCategoryMerchandises($id,$categoryId);
        return $this->response()->paginator($items,new StoreMerchandiseTransformer());
    }

    /**
     * 库存统计
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeStockStatistics(StoreStockListRequest $request)
    {
        $user = $this->mpUser();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        $user['shop_id'] = $shopUser['id'];
        $store = $request->all();
        if ($store['store_id'] != $user['shop_id']){
            return $this->response(new JsonResponse(['message' => '所传店铺id不是当前登陆用户的店铺id']));
        }
        $items  = $this->shopMerchandiseRepository->storeStockMerchandise($store);
        return $this->response()->paginator($items,new StoreStockStatisticsTransformer);
    }

    /**
     * 修改库存
     * @param $id
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeMerchandiseStock(int $merchandiseId,StoreStockUpdateRequest $request)
    {
        $user = $this->mpUser();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        $user['shop_id'] = $shopUser['id'];

        //获取此店铺此商品的信息
        $storeMerchandise = $this->shopMerchandiseRepository->findWhere([
            'merchandise_id'=>$merchandiseId,
            'shop_id'=>$shopUser['id']
        ])->first();

        $request = $request->input();
        $request['stock_num'] = $request['modify_stock_num'];

        $item = $this->shopMerchandiseRepository->update($request,$storeMerchandise['id']);
        if ($item){
            $storeStockModify['shop_id'] = $storeMerchandise['shop_id'];
            $storeStockModify['product_id'] = $storeMerchandise['product_id'];
            $storeStockModify['merchandise_id'] = $merchandiseId;
            $storeStockModify['primary_stock_num'] = $request['primary_stock_num'];
            $storeStockModify['modify_stock_num'] = $request['modify_stock_num'];
            $storeStockModify['reason'] = $request['reason'];
            $storeStockModify['comment'] = $request['comment'];
            $this->merchandiseStockModifyRepository->create($storeStockModify);
            return $this->response()->item($item,new ShopMerchandiseStockModifyTransformer());
        }
            return $this->response(new JsonResponse(['message' => '库存修改失败,请稍后再试']));
    }

    /**
     * 预定商城搜索商品
     * @param Request $request
     */
    public function reserveSearchMerchandises(Request $request){
        if ($request['name']){
            $items = $this->merchandiseRepository->searchMerchandises($request['name']);
            return $this->response()->paginator($items,new ReserveSearchMerchandisesTransformer());
        }else{
            return $this->response(new JsonResponse(['message' => '搜索的商品名字不能为空']));
        }
    }
}