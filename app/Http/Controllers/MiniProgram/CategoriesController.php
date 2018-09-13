<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:27
 */

namespace App\Http\Controllers\MiniProgram;
use App\Repositories\CategoryRepository;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseCategoryRepository;
use Dingo\Api\Http\Request;
use App\Transformers\Mp\CategoriesTransformer;
use App\Transformers\Mp\MerchandisesTransformer;
use App\Transformers\Mp\StoreMerchandiseTransformer;
use App\Transformers\Mp\StoreCategoriesTransformer;
use App\Transformers\Mp\StoreStockStatisticsTransformer;
use App\Repositories\ShopMerchandiseRepository;


class CategoriesController extends Controller
{
    protected  $categoryRepository = null;

    protected  $merchandiseCategoryRepository = null;

    protected  $shopMerchandiseRepository = null;
    /**
     * CategoriesController constructor.
     * @param CategoryRepository $categoryRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(CategoryRepository $categoryRepository,MerchandiseCategoryRepository $merchandiseCategoryRepository,ShopMerchandiseRepository $shopMerchandiseRepository, AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->categoryRepository = $categoryRepository;
        $this->merchandiseCategoryRepository = $merchandiseCategoryRepository;
        $this->shopMerchandiseRepository = $shopMerchandiseRepository;
    }
    /*
     * 获取预定商城所有分类
     */
    public function categories(){
        $item = $this->categoryRepository->paginate();
        return $this->response->paginator($item,new CategoriesTransformer);
    }
    /*
     * 根据分类获取所有商品信息
     * $param int $id
     */

    public function categoriesMerchandises(int $id){
      $item = $this->merchandiseCategoryRepository->merchandises($id);
      return $this->response->paginator($item,new MerchandisesTransformer());
    }

    /*
     * 一个店铺下的所有分类
     * @param int $id
     */

    public function storeCategories(int $id){
        $item = $this->shopMerchandiseRepository->storeCategories($id);
        return $this->response->paginator($item,new StoreCategoriesTransformer);
    }

    /**
     * 一个店铺分类下的商品信息
     * @param int $id
     * @param int $categoryId
     */
    public function storeMerchandise(int $id ,int $categoryId){
        $item = $this->shopMerchandiseRepository->storeMerchandise($id,$categoryId);
        return $this->response->paginator($item,new StoreMerchandiseTransformer());
    }

    /**
     * @param Request $request
     */
    public function storeStockStatistics(Request $request){
        $store = $request->all();
        $item  = $this->shopMerchandiseRepository->storeStockMerchandise($store);
        return $this->response()->paginator($item,new StoreStockStatisticsTransformer);
    }

}