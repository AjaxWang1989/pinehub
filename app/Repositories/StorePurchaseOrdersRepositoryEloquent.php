<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:21
 */

namespace App\Repositories;
use App\Criteria\Admin\SearchRequestCriteria;
use App\Repositories\Traits\Destruct;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\StorePurchaseOrders;
use App\Validators\StorePurchaseOrdersValidator;


class StorePurchaseOrdersRepositoryEloquent extends BaseRepository implements StorePurchaseOrdersRepository
{
    use Destruct;
    protected $fieldSearchable = [
        'type',
        'pay_type',
        'status',
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
        return StorePurchaseOrders::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(SearchRequestCriteria::class);
        StorePurchaseOrders::creating(function (StorePurchaseOrders &$storePurchaseOrders){
            $storePurchaseOrders->code =  app('uid.generator')->getUid(ORDER_CODE_FORMAT, ORDER_SEGMENT_MAX_LENGTH);
            return $storePurchaseOrders;
        });
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */

    public function storePurchaseStatistics(array $request,int $userId)
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
        $this->scopeQuery(function (StorePurchaseOrders $storePurchaseOrders) use($userId,$request, $startAt, $endAt){
            return $storePurchaseOrders->select([DB::raw('sum(`payment_amount`) as total_amount')])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->first('total_amount');
    }

    /**
     * @param array $request
     * @param int $userId
     * @return mixed
     */
    public function storeOrders(array $request,int $userId)
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

        $this->scopeQuery(function (StorePurchaseOrders $storePurchaseOrders) use($userId,$request, $startAt, $endAt){
            return $storePurchaseOrders->select([
                'code','paid_at','type','status','payment_amount'])
                ->where(['shop_id'=>$userId])
                ->where('paid_at', '>=', $startAt)
                ->where('paid_at', '<', $endAt);
        });
        return $this->paginate();
    }
}