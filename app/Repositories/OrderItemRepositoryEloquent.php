<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderItemRepository;
use App\Entities\OrderItem;
use App\Entities\Order;
use App\Validators\OrderItemValidator;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class OrderItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderItemRepositoryEloquent extends BaseRepository implements OrderItemRepository
{
    use Destruct;

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
        return OrderItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
        }
        OrderItem::creating(function (OrderItem &$orderItem) {
            //$orderItem->code = app('uid.generator')->getUid();
            return $orderItem;
        });
    }

    /**
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return mixed
     */
    public function sellMerchandiseNum(int $shopId, Carbon $startAt, Carbon $endAt)
    {
        $this->scopeQuery(function (OrderItem $orderItem) use($shopId, $startAt, $endAt){
            return $orderItem->select([DB::raw('sum(`quality`) as total_amount')])
                ->whereIn('status',[Order::PAID, Order::SEND, Order::COMPLETED])
                ->where(['shop_id' => $shopId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->first('total_amount');
    }

    /**
     * 消费排名
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $limit
     * @return mixed
     */
    public function consumptionRanking(int $shopId, Carbon $startAt, Carbon $endAt, int $limit = 5)
    {
        $this->scopeQuery(function (OrderItem $orderItem) use($shopId, $startAt, $endAt,$limit) {
            return $orderItem->select([
                DB::raw('customers.nickname as customer_nickname'),
                DB::raw('sum( `payment_amount` ) as total_payment_amount')
            ])->join('customers', 'order_items.customer_id', '=', 'customers.id')
                ->whereIn('status',[Order::PAID, Order::SEND, Order::COMPLETED])
                ->where(['shop_id' => $shopId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->whereIn('type', [Order::SITE_USER_ORDER, Order::SHOPPING_MALL_ORDER,
                    Order::OFF_LINE_PAYMENT_ORDER])
                ->groupby('customer_id')
                ->orderBy('total_payment_amount','desc')
                ->limit($limit);
        });
        return $this->get();
    }

    /**
     * @param int $shopId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int $limit
     * @return mixed
     */
    public function merchandiseSalesRanking(int $shopId, Carbon $startAt, Carbon $endAt, int $limit = 5)
    {
        $this->scopeQuery(function (OrderItem $orderItem) use($shopId, $startAt, $endAt, $limit) {
            return $orderItem->select([
                'merchandise_name',
                DB::raw('sum( `payment_amount` ) as total_payment_amount')])
                ->whereIn('status',[Order::PAID, Order::SEND, Order::COMPLETED])
                ->where(['shop_id' => $shopId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('name')
                ->orderBy('total_amount','desc')
                ->limit($limit);
        });
        return $this->get();
    }
}
