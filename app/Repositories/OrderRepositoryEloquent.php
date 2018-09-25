<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Criteria\Admin\SearchRequestCriteria;
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
        'type',
        'pay_type',
        'status',
        'customer_id',
        'member.mobile',
        'orderItemMerchandise.name',
        'code'
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
        $this->pushCriteria(SearchRequestCriteria::class);
        Order::creating(function (Order &$order){
            $order->code =  app('uid.generator')->getUid(ORDER_CODE_FORMAT, ORDER_SEGMENT_MAX_LENGTH);
            return $order;
        });
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

    public function storeBuffetOrders(array $sendTime,int $userId,$limit = '15')
    {
        $startAt = null;
        $endAt = null;

        $startAt = $sendTime['send_start_time'];
        $endAt = $sendTime['send_end_time'];

        $this->scopeQuery(function (Order $order) use($userId,$startAt,$endAt) {
            return $order->with('orderItems')->where(['shop_id'=>$userId])
                ->where('send_time', '>=', $startAt)
                ->where('send_time', '<', $endAt)
                ->whereIn('type', [Order::ORDERING_PAY,Order::SITE_SELF_EXTRACTION]);
        });
        return $this->paginate($limit);
    }

    /**
     * @param $sendTime
     * @param $userId
     * @param string $limit
     * @return mixed
     */
    public function storeSendOrders(array $sendTime,int $userId,$limit = '15')
    {
        $startAt = null;
        $endAt = null;

        $startAt = $sendTime['send_start_time'];
        $endAt = $sendTime['send_end_time'];

        $this->scopeQuery(function (Order $order) use($userId,$startAt,$endAt) {
            return $order->with('orderItems')->where(['shop_id'=>$userId])
                ->where('send_time', '>=', $startAt)
                ->where('send_time', '<', $endAt)
                ->whereIn('type', [Order::E_SHOP_PAY,Order::SITE_DISTRIBUTION]);
        });
        return $this->paginate($limit);
    }

    /**
     * @param string $status
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function allOrders(string $status,int $userId,$limit = '15')
    {
        $this->scopeQuery(function (Order $order) use($status,$userId){
            return $order->with('orderItems')->where(['shop_id'=>$userId,'status'=>$status]);
        });
        return $this->paginate($limit);
    }

    /**
     * @param array $request
     * @param int $userId
     * @param string $limit
     * @return mixed
     */

    public function storeOrdersSummary(array $request,int $userId,$limit = '15')
    {
        $startAt = null;
        $endAt = null;

        $startAt = $request['send_start_time'];
        $endAt = $request['send_end_time'];

        $this->scopeQuery(function (Order $order) use($userId,$request,$startAt,$endAt) {
            return $order->with('orderItems')
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->where('type',$request['type'])
                ->where('status',$request['status']);
        });
        return $this->paginate($limit);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function orderStatistics(array $request,int $userId)
    {
        $startAt = null;
        $endAt = null;
        $limit =  null;
        if ($request['date'] == 'hour')
        {
            $startAt = $this->hourStartAt;
            $endAt  = $this->hourEndAt;
            $limit = '24';
        }else if($request['date'] == 'week')
        {
            $startAt = $this->weekStartAt;
            $endAt  = $this->weekEndAt;
            $limit = '7';
        }else if($request['date'] == 'month')
        {
            $startAt = $this->montStartAt;
            $endAt  = $this->monthEndAt;
            $limit = '31';
        }
        $this->scopeQuery(function (Order $order) use($userId,$request, $startAt, $endAt,$limit) {
            return $order->select([
                $request['date'],
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby($request['date'])->orderBy($request['date'])->limit($limit);
        });
        return $this->get();
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
                DB::raw('count( * ) as buy_mum'))
                ->where(['shop_id'=>$request['store_id']])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('week')->orderBy('week')->limit($limit);
        });
        return $this->get();
    }
}
