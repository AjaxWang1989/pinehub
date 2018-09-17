<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\OrderItemMerchandise;
use App\Validators\OrderItemMerchandiseValidator;

/**
 * Class OrderItemMerchandiseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderItemMerchandiseRepositoryEloquent extends BaseRepository implements OrderItemMerchandiseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderItemMerchandise::class;
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
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function orderItemUser (int $userId,$limit='15')
    {
        $this->scopeQuery(function (OrderItemMerchandise $orderItemMerchandise)use($userId){
            return $orderItemMerchandise->select([
                'customer_id',
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->groupby('customer_id')->orderBy('total_amount');
        });
        return $this->paginate($limit);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellMerchandiseNum(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = date('Y-m_d 00:00:00',time());
            $endAt  = date('Y-m-d 23:59:59',time());
        }else if($request['date'] == 'week')
        {
            $startAt = date('Y-m-d 00:00:00', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
            $endAt  = date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));
        }else if($request['date'] == 'month')
        {
            $startAt = date('Y-m-d 00:00:00', strtotime(date('Y-m', time()) . '-01 00:00:00'));
            $endAt  = date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 00:00:00'));
        }
        $this->scopeQuery(function (OrderItemMerchandise $orderItemMerchandise) use($userId,$request, $startAt, $endAt){
            return $orderItemMerchandise->select([DB::raw('sum(`quality`) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->first('total_amount');
    }

    /**
     * @param array $request
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function sellTop(array $request,int $userId,$limit='5')
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = date('Y-m_d 00:00:00',time());
            $endAt  = date('Y-m-d 23:59:59',time());
        }else if($request['date'] == 'week')
        {
            $startAt = date('Y-m-d 00:00:00', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
            $endAt  = date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));
        }else if($request['date'] == 'month')
        {
            $startAt = date('Y-m-d 00:00:00', strtotime(date('Y-m', time()) . '-01 00:00:00'));
            $endAt  = date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 00:00:00'));
        }
        $this->scopeQuery(function (OrderItemMerchandise $orderItemMerchandise) use($userId,$request, $startAt, $endAt,$limit) {
            return $orderItemMerchandise->select([
                DB::raw('customers.nickname as customer_nickname'),
                DB::raw('sum( `payment_amount` ) as total_amount')
                ])
                ->join('customers', 'order_item_merchandises.customer_id', '=', 'customers.id')
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('customer_id')->orderBy('total_amount','desc')->limit($limit);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function sellMerchandiseTop(array $request,int $userId,$limit='5')
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = date('Y-m_d 00:00:00',time());
            $endAt  = date('Y-m-d 23:59:59',time());
        }else if($request['date'] == 'week')
        {
            $startAt = date('Y-m-d 00:00:00', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
            $endAt  = date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));
        }else if($request['date'] == 'month')
        {
            $startAt = date('Y-m-d 00:00:00', strtotime(date('Y-m', time()) . '-01 00:00:00'));
            $endAt  = date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 00:00:00'));
        }
        $this->scopeQuery(function (OrderItemMerchandise $orderItemMerchandise) use($userId,$request, $startAt, $endAt,$limit) {
            return $orderItemMerchandise->select([
                'name',
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('name')->orderBy('total_amount','desc')->limit($limit);
        });
        return $this->get();
    }

}
