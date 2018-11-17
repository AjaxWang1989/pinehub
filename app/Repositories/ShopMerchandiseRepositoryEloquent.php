<?php

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\ShopMerchandise;


/**
 * Class ShopMerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShopMerchandiseRepositoryEloquent extends BaseRepository implements ShopMerchandiseRepository
{
    protected $fieldSearchable = [
        'merchandise.name' => 'like',
        'sell_num'=>'*',
        'sell_price' => '*',
        'merchandise.status' => '='
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShopMerchandise::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param int $id
     * @param string $limit
     */

    public function storeCategories(int $id){
        $this->scopeQuery(function (ShopMerchandise $ShopCategory) use($id) {
            return $ShopCategory->select([
                DB::raw('category_id as id'),
                DB::raw('categories.name as name')
            ])
                ->join('categories', 'shop_merchandises.category_id', '=', 'categories.id')
                ->where(['shop_id'=>$id])
                ->groupBy('category_id');
        });
        return $this->paginate();
    }

    /**
     * @param int $id
     * @param int $categoryId
     * @param string $limit
     */
    public function storeCategoryMerchandises(int $id,int $categoryId){
        $this->scopeQuery(function (ShopMerchandise $ShopMerchandise) use($id,$categoryId) {
            return $ShopMerchandise->with('merchandise')->where(['shop_id'=>$id,'category_id'=>$categoryId]);
        });
        return $this->paginate();
    }

    /**
     * @param $store
     * @return mixed
     */
    public function storeStockMerchandise($store){
        $this->scopeQuery(function (ShopMerchandise $ShopMerchandise) use($store) {
            return $ShopMerchandise->with('merchandise')->where(['shop_id'=>$store['store_id'],'category_id'=>$store['category_id']]);
        });
        return $this->paginate();
    }

    /**
     * @param int $shopId
     * @param array $merchandisesIds
     * @return mixed
     */
    public function shopMerchandises(int $shopId,array $merchandisesIds){
        $this->scopeQuery(function (ShopMerchandise $ShopMerchandise) use($shopId,$merchandisesIds) {
            return $ShopMerchandise->where('shop_id',$shopId)
                ->whereIn('id',$merchandisesIds);
        });
        return $this->paginate();
    }
}
