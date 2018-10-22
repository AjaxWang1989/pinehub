<?php /** @noinspection ALL */

namespace App\Repositories;

use App\Repositories\Traits\Destruct;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderItemRepository;
use App\Entities\OrderItem;
use App\Validators\OrderItemValidator;

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
        $this->pushCriteria(app(RequestCriteria::class));
        OrderItem::creating(function (OrderItem &$orderItem) {
            //$orderItem->code = app('uid.generator')->getUid();
            return $orderItem;
        });
    }

    /**
     * @param int $userId
     * @param string $limit
     * @return mixed
     */
    public function orderItemUser (int $userId)
    {
        $this->scopeQuery(function (OrderItem $orderItem)use($userId){
            return $orderItem->select([
                'customer_id',
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->groupby('customer_id')->orderBy('total_amount');
        });
        return $this->paginate();
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
        $this->scopeQuery(function (OrderItem $orderItem) use($userId,$request, $startAt, $endAt){
            return $orderItem->select([DB::raw('sum(`quality`) as total_amount')])
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
        $this->scopeQuery(function (OrderItem $orderItem) use($userId,$request, $startAt, $endAt,$limit) {
            return $orderItem->select([
                DB::raw('customers.nickname as customer_nickname'),
                DB::raw('sum( `payment_amount` ) as total_amount')
            ])
                ->join('customers', 'order_items.customer_id', '=', 'customers.id')
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
        $this->scopeQuery(function (OrderItem $orderItem) use($userId,$request, $startAt, $endAt,$limit) {
            return $orderItem->select([
                'name',
                DB::raw('sum( `payment_amount` ) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt)
                ->groupby('name')->orderBy('total_amount','desc')->limit($limit);
        });
        return $this->get();
    }

    public function OrderItemMerchandises(int $id){
        $this->scopeQuery(function (OrderItem $orderItem) use($id) {
            return $orderItem->select([
                DB::raw('name,sell_price,quality,total_amount,main_image')
            ])
                ->where(['order_id'=>$id]);
        });
        return $this->get();
    }

}
