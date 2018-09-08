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

    public function storeCategories(int $id,$limit = '15'){
        $this->scopeQuery(function (ShopMerchandise $ShopCategory) use($id) {
            return $ShopCategory->with('category')->where(['shop_id'=>$id])->groupby('category_id');
        });
        return $this->paginate($limit);
    }

    /**
     * @param int $id
     * @param int $categoryId
     * @param string $limit
     */
    public function storeMerchandise(int $id,int $categoryId,$limit = '15'){
        $this->scopeQuery(function (ShopMerchandise $ShopMerchandise) use($id,$categoryId) {
            return $ShopMerchandise->with('merchandise')->where(['shop_id'=>$id,'category_id'=>$categoryId]);
        });
        return $this->paginate($limit);
    }
}
