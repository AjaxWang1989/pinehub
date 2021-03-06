<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 14:59
 */

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Illuminate\Support\Facades\Request;
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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param int $storeId
     * @param int|null $activityId
     * @param int $userId
     * @param string $type
     * @return mixed
     */

    public function shoppingCartMerchandises(int $storeId = null, int $activityId = null ,
                                             int $userId = null, string $type = ShoppingCart::USER_ORDER){
        if (isset($storeId) && $storeId){
            $where = ['customer_id'=>$userId,'shop_id'=>$storeId];
        }elseif(isset($activityId) && $activityId){
            $where = ['customer_id'=>$userId,'activity_id'=>$activityId];
        } else{
            $where = ['customer_id'=>$userId,'shop_id'=>null,'activity_id'=>null];
        }
        $where['type'] = $type;
        $count = $this->model->where($where)->count();
        $this->scopeQuery(function (ShoppingCart $shoppingCart) use($where) {
            return $shoppingCart->with('merchandise')->where($where);
        });

        return $this->paginate(Request::input('limit', $count > 0 ? $count : PAGE_LIMIT));
    }
}