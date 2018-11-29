<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\OrderItem;
use App\Entities\ShopMerchandise;
use App\Repositories\Traits\Destruct;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Collection;
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
     * 自提
     * @param $sendTime
     * @param $shopId
     * @param string $limit
     * @return mixed
     */

    public function storeBuffetOrders($startAt, $endAt, int $shopId)
    {
        $this->scopeQuery(function (Order $order) use($shopId,$startAt,$endAt) {
            return $order
                ->where(['shop_id' => $shopId])
                ->whereIn('status',[
                    Order::PAID,
                    Order::SEND,
                    Order::COMPLETED])
                ->where('pick_up_start_time', '>=', $startAt)
                ->where('pick_up_end_time', '<', $endAt)
                ->whereIn('type', [
                    Order::SHOPPING_MALL_ORDER,
                    Order::SITE_USER_ORDER
                ])->where('pick_up_method', Order::USER_SELF_PICK_UP)
                ->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * 配送订单
     * @param $sendTime
     * @param $shopId
     * @param string $limit
     * @return mixed
     */
    public function storeSendOrders(array $sendTime,int $shopId)
    {
        $startAt = null;
        $endAt = null;

        $startAt = $sendTime['send_start_time'];
        $endAt = $sendTime['send_end_time'];

        $this->scopeQuery(function (Order $order) use($shopId, $startAt, $endAt) {
            return $order
                ->where(['shop_id'=>$shopId])
                ->whereIn('status',[
                    Order::PAID,
                    Order::SEND,
                    Order::COMPLETED
                ])->where('send_start_time', '=', $startAt)
                ->where('send_end_time', '=', $endAt)
                ->whereIn('type', [
                    Order::SHOPPING_MALL_ORDER,
                    Order::SITE_USER_ORDER
                ])->where('pick_up_method', Order::SEND_ORDER_TO_USER)
                ->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * @param string $status
     * @param int $customerId
     * @param string $limit
     * @return mixed
     */
    public function orders(string $status, int $customerId)
    {
        $where = [];
        if ($status == 'success'){
            $where = ['customer_id' => $customerId,'status' => Order::PAID];
        }elseif ($status == 'completed'){
            $where = ['customer_id' => $customerId,'status' => Order::COMPLETED];
        }elseif ($status == 'all'){
            $where = ['customer_id' => $customerId];
        }
        $this->scopeQuery(function (Order $order) use($where){
            return $order->where($where)->orderBy('id','desc');
        });
        return $this->paginate();
    }

    /**
     * @param array $request
     * @param int $shopId
     * @param string $limit
     * @return mixed
     */

    public function storeOrdersSummary($status, $startAt, $endAt ,int $shopId, $type = null)
    {
        $startAt = null;
        $endAt = null;


        $where = [];
        if ($status == 'all'){
            $where = ['shop_id'=> $shopId];
        }elseif ($status == 'send'){
            $where = ['shop_id'=> $shopId,'status'=>Order::PAID];
        }elseif ($status == 'completed'){
            $where = ['shop_id'=> $shopId,'status'=>Order::COMPLETED];
        }

        $this->scopeQuery(function (Order $order) use($where, $startAt, $endAt, $type) {
            $order = $order->where($where)
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
            if($type)
                return $order->whereIn('type', [Order::SHOPPING_MALL_ORDER, Order::SITE_USER_ORDER])
                    ->where('pick_up_method', $type === 'self_pick_up'? Order::USER_SELF_PICK_UP : Order::SEND_ORDER_TO_USER );
            else
                return $order;
        });
        return $this->paginate();
    }

    /**
     * 订单统计
     * @param int $shopId
     * @param string $unit
     * @return Collection
     */
    public function orderStatistics(int $shopId, string $unit, Carbon $startAt, Carbon $endAt, int $limit)
    {
        $this->scopeQuery(function (Order $order) use ($shopId, $unit, $startAt, $endAt, $limit) {
            return $order->select([
                $unit,
                DB::raw('sum( `payment_amount` ) as total_payment_amount'),
                'type',
                DB::raw('count(`*`) as order_count'),
                DB::raw('sum( `merchandise_num` ) as merchandise_count'),
                'paid_at'])
                ->whereIn('status', [Order::PAID, Order::SEND, Order::COMPLETED])
                ->where(['shop_id' => $shopId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->whereIn('type', [Order::SHOPPING_MALL_ORDER, Order::SITE_USER_ORDER, Order::OFF_LINE_PAYMENT_ORDER])
                ->groupby($unit)
                ->orderBy($unit, 'desc')
                ->limit($limit);
        });
        $orders = $this->get();
        return $orders;
    }

    public function buildOrderStatisticData(Collection $orders, $count, $unit)
    {
        $statisticsData = [ ];
        //循环组装当前截止时间的数据
        for ($i = 0; $i < $count ; $i++){
            $statisticsData[$i] = 0;
            $orders->map(function ($order, $index) use($statisticsData, $unit, $i){
                if($order[$unit] === $i + 1){
                    $statisticsData[$i] = $order['total_payment_amount'];
                }
            });
        }
        //预定产品金额总和
        $bookPaymentAmount = $orders
            ->where('type', Order::SHOPPING_MALL_ORDER)
            ->sum('total_payment_amount');
        //站点产品金额总和
        $sitePaymentAmount = $orders
            ->where('type', Order::SITE_USER_ORDER)
            ->sum('total_payment_amount');
        //销售单品数量总和
        $sellMerchandiseNum = $orders->sum('merchandise_count');
        //销售笔数
        $sellOrderNum = $orders->sum('order_count');
        return [
            'order_statistics' => $statisticsData,
            'total_order_amount' => $bookPaymentAmount + $sitePaymentAmount,
            'booking_order_total_payment_amount' => $bookPaymentAmount,
            'store_order_total_payment_amount' => $sitePaymentAmount,
            'sell_merchandise_num' => $sellMerchandiseNum,
            'order_total_num' => $sellOrderNum
        ];
    }

    /**
     * @param int $activityId
     * @param int $customerId
     * @param string $limit
     * @return mixed
     */
    public function receivingShopAddress(int $activityId , int $customerId, $limit = 3){
        $this->scopeQuery(function (Order $order) use($activityId , $customerId ,$limit){
            return $order
                ->where('customer_id', $customerId)
                ->where('activity_id', $activityId)
                ->groupBy('receiving_shop_id');
        });
        return $this->paginate($limit);
    }


}
