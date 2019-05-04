<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:28
 */

namespace App\Repositories;
use App\Repositories\Traits\Destruct;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\OrderPurchaseItems;
use App\Validators\OrderPurchaseItemsValidator;


class OrderPurchaseItemsRepositoryEloquent extends BaseRepository implements OrderPurchaseItemsRepository
{
    use Destruct;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderPurchaseItems::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        OrderPurchaseItems::creating(function (OrderPurchaseItems &$orderPurchaseItems) {
            //$orderItem->code = app('uid.generator')->getUid();
            return $orderPurchaseItems;
        });
    }

    public function orderPurchaseItems(int $order_id,int $shop_id)
    {
        $this->scopeQuery(function (OrderPurchaseItems $orderPurchaseItems) use($order_id,$shop_id){
            return $orderPurchaseItems->select([
                'id','shop_id','merchandise_id','quality'])
                ->where(['shop_id'=>$shop_id,'order_id'=>$order_id,'status'=>OrderPurchaseItems::WAIT]);
        });
        return $this->get();
    }
}