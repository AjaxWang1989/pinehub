<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 14:59
 */

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\ShoppingCart;
use App\Validators\ShoppingCartValidator;



class ShoppingCartRepositoryEloquent extends BaseRepository implements ShoppingCartRepository
{
    use Destruct;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ShoppingCart::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param int $storeId
     * @param int $userId
     * @return mixed
     */

    public function shoppingCartMerchandises(int $storeId = null,int $activityMerchandiseId = null ,$userId){
        if (isset($storeId) && $storeId){
            $where = ['customer_id'=>$userId,'shop_id'=>$storeId];
        }elseif(isset($activityMerchandiseId) && $activityMerchandiseId){
            $where = ['customer_id'=>$userId,'activity_merchandises_id'=>$activityMerchandiseId];
        } else{
            $where = ['customer_id'=>$userId,'shop_id'=>null,'activity_merchandises_id'=>null];
        }
        $this->scopeQuery(function (ShoppingCart $shoppingCart) use($where) {
            return $shoppingCart->with('merchandise')->where($where);
        });
        return $this->paginate();
    }
}