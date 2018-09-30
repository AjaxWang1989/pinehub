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
     * @param string $limit
     * @return mixed
     */

    public function shoppingCartMerchandises(int $storeId,$userId,$limit='15'){
        $this->scopeQuery(function (ShoppingCart $shoppingCart) use($storeId,$userId) {
            return $shoppingCart->with('merchandise')->where(['customer_id'=>$userId,'shop_id'=>$storeId]);
        });
        return $this->paginate($limit);
    }
}