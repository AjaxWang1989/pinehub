<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\OrderItem;
use App\Entities\ShopMerchandise;
use App\Repositories\Traits\Destruct;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Order;
use App\Validators\Api\OrderValidator;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'type' => '=',
        'pay_type' => '=',
        'status' => '=',
        'customer_id' => '=',
        'member.mobile' => 'like',
        'orderItems.name' => 'like',
        'code' => 'like',
        'paid_at' => '*',
        'receiver_name' => 'like',
        'receiver_mobile' > 'like'
    ];
    protected $hourStartAt ;
    protected $hourEndAt;

    protected $weekStartAt;
    protected $weekEndAt;

    protected $montStartAt;
    protected $monthEndAt;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->hourStartAt = date('Y-m_d 00:00:00',time());
        $this->hourEndAt = date('Y-m-d 23:59:59',time());

        $this->weekStartAt = date('Y-m-d 00:00:00', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
        $this->weekEndAt = date('Y-m-d 23:59:59', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));

        $this->montStartAt = date('Y-m-d 00:00:00', strtotime(date('Y-m', time()) . '-01 00:00:00'));
        $this->monthEndAt = date('Y-m-d 23:59:59', strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 00:00:00'));

    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }



    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
//        $this->pushCriteria(SearchRequestCriteria::class);

    }

    /**
     * @param $data
     * @return bool
     */
    public function insertMerchandise(array $itemMerchandises)
    {
        $item = DB::table('order_items')->insert($itemMerchandises);
        return $item;
    }

    /**
     * @param $sendTime
     * @param $userId
     * @param string $limit
     * @return mixed
     */

    public function storeBuffetOrders(array $sendTime,int $userId)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $sendTime['paid_start_time'];
        $endAt = $sendTime['paid_end_time'];

        $this->scopeQuery(function (Order $order) use($userId,$startAt,$endAt) {
            return $order
                ->where(['shop_id'=>$userId])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->whereIn('type', [Order::ORDERING_PAY,Order::SITE_SELF_EXTRACTION])
                ->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * @param $sendTime
     * @param $userId
     * @param string $limit
     * @return mixed
     */
    public function storeSendOrders(array $sendTime,int $userId)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $sendTime['send_start_time'];
        $endAt = $sendTime['send_end_time'];

        $this->scopeQuery(function (Order $order) use($userId,$startAt,$endAt) {
            return $order
                ->where(['shop_id'=>$userId])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('send_start_time', '=', $startAt)
                ->where('send_end_time', '=', $endAt)
                ->whereIn('type', [Order::E_SHOP_PAY,Order::SITE_DISTRIBUTION])
                ->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * @param string $status
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function orders(string $status,int $customerId)
    {
        $where = [];
        if ($status == 'success'){
            $where = ['customer_id'=>$customerId,'status'=>Order::PAID];
        }elseif ($status == 'completed'){
            $where = ['customer_id'=>$customerId,'status'=>Order::COMPLETED];
        }elseif ($status == 'all'){
            $where = ['customer_id'=>$customerId];
        }
        $this->scopeQuery(function (Order $order) use($where){
            return $order->where($where)->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * @param array $request
     * @param int $userId
     * @param string $limit
     * @return mixed
     */

    public function storeOrdersSummary(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;

        $type = null;
        //type传reserve就是预定商品  type传self_lift 就是自提商品
        if ($request['type'] == 'self_lift'){
            $type = [Order::ORDERING_PAY,Order::SITE_SELF_EXTRACTION];
        }elseif ($request['type'] == 'reserve'){
            $type = [Order::E_SHOP_PAY,Order::SITE_DISTRIBUTION];
        }


        $where = [];
        if ($request['status'] == 'all'){
            $where = ['shop_id'=> $userId];
        }elseif ($request['status'] == 'send'){
            $where = ['shop_id'=> $userId,'status'=>Order::PAID];
        }elseif ($request['status'] == 'completed'){
            $where = ['shop_id'=> $userId,'status'=>Order::COMPLETED];
        }

        $startAt = $request['paid_start_time'];
        $endAt = $request['paid_end_time'];

        $this->scopeQuery(function (Order $order) use($where,$startAt,$endAt,$type) {
            $order = $order
                ->where($where)
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
            if($type)
                return $order->whereIn('type', $type);
            else
                return $order;
        });
        return $this->paginate();
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function orderStatistics(array $request,int $userId)
    {
        $startAt =  null;
        $endAt   =  null;
        $limit   =  null;
        $date    =  null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
            $limit = '24';
            $date = 'hour';
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
            $limit = '7';
            $date = 'week';
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
            $limit = '31';
            $date = 'day';
        }
        $this->scopeQuery(function (Order $order) use($userId,$date, $startAt, $endAt,$limit) {
            return $order->select([
                $date,
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby($date)->orderBy($date,'desc')->limit($limit);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function orderDateHigh(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        $limit =  null;
        $date    =  null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
            $limit = '24';
            $date = 'hour';
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
            $limit = '7';
            $date = 'week';
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
            $limit = '31';
            $date = 'day';
        }
        $this->scopeQuery(function (Order $order) use($userId,$date, $startAt, $endAt,$limit) {
            return $order->select([
                $date,
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby($date)->orderBy($date,'desc')->limit(1);
        });
        return $this->get()->first();
    }


    /**
 * @param array $request
 * @param int $userId
 * @return mixed
 */
    public function bookPaymentAmount(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
        }
        $this->scopeQuery(function (Order $order) use($userId,$request, $startAt, $endAt){
            return $order->select([DB::raw('sum(`payment_amount`) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->whereIn('type', [Order::ORDERING_PAY,Order::E_SHOP_PAY]);
        });
        return $this->first('total_amount');
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sitePaymentAmount(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
        }
        $this->scopeQuery(function (Order $order) use($userId,$request, $startAt, $endAt){
            return $order->select([DB::raw('sum(`payment_amount`) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->whereIn('type', [Order::SITE_SELF_EXTRACTION,Order::SITE_DISTRIBUTION]);
        });
        return $this->first('total_amount');
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function sellOrderNum(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
        }
        $this->scopeQuery(function (Order $order) use($userId,$request, $startAt, $endAt){
            return $order->where(['shop_id'=>$userId])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function todaySellAmount(array $request)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->hourStartAt;
        $endAt  = $this->hourEndAt;

        $this->scopeQuery(function (Order $order) use($request, $startAt, $endAt){
            return $order->select([DB::raw('sum(`payment_amount`) as total_amount')])
                ->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->first('total_amount');

    }

    /**
     * @param array $request
     * @return mixed
     */
    public function weekSellAmount(array $request)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->weekStartAt;
        $endAt  = $this->weekEndAt;

        $this->scopeQuery(function (Order $order) use($request, $startAt, $endAt){
            return $order->select([DB::raw('sum(`payment_amount`) as total_amount')])
                ->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->first('total_amount');

    }

    /**
     * @param array $request
     * @param string $limit
     * @return mixed
     */
    public function sellAmount(array $request,$limit = '7')
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->weekStartAt;
        $endAt  = $this->weekEndAt;

        $this->scopeQuery(function (Order $order) use ($request, $startAt, $endAt,$limit){
            return $order->select('week',
                DB::raw('sum( `payment_amount` ) as total_amount'))
                ->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('week')->orderBy('week')->limit($limit);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function todayBuyNum(array $request)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->hourStartAt;
        $endAt  = $this->hourEndAt;

        $this->scopeQuery(function (Order $order) use ($request, $startAt, $endAt){
            return $order->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function weekBuyNum(array $request)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->weekStartAt;
        $endAt  = $this->weekEndAt;

        $this->scopeQuery(function (Order $order) use ($request, $startAt, $endAt){
            return $order->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->get();
    }

    /**
     * @param array $request
     * @param string $limit
     * @return mixed
     */
    public function weekStatistics(array $request,$limit = '7')
    {
        $startAt = null;
        $endAt = null;

        $startAt = $this->weekStartAt;
        $endAt  = $this->weekEndAt;

        $this->scopeQuery(function (Order $order) use ($request, $startAt, $endAt,$limit){
            return $order->select('week',
                DB::raw('count( * ) as buy_num'))
                ->where(['shop_id'=>$request['store_id']])
                ->whereIn('status',[Order::PAID,Order::SEND,Order::COMPLETED])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('week')->orderBy('week')->limit($limit);
        });
        return $this->get();
    }

    /**
     * @param int $activity
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function receivingShopAddress(int $activity , int $userId,$limit = '3'){
        $this->scopeQuery(function (Order $order) use($activity , $userId ,$limit){
            return $order
                ->where('customer_id',$userId)
                ->where('activity_id',$activity)
                ->groupBy('receiving_shop_id');
        });
        return $this->paginate($limit);
    }


}
