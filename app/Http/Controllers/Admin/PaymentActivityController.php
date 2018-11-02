<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Activity;
use App\Entities\Order;
use App\Entities\PaymentActivity;
use App\Http\Response\JsonResponse;
use App\Repositories\OrderRepository;
use App\Services\AppManager;
use Exception;
use App\Http\Requests\Admin\OrderGiftCreateRequest;
use App\Http\Requests\Admin\OrderGiftUpdateRequest;
use App\Transformers\OrderGiftTransformer;
use App\Transformers\OrderGiftItemTransformer;
use App\Repositories\ActivityRepository;
use App\Repositories\PaymentActivityRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentActivityController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class PaymentActivityController extends Controller
{
    /**
     * @var ActivityRepository
     */
    protected $repository;

    protected $paymentActivity;


    /**
     * PaymentActivityController constructor.
     *
     * @param ActivityRepository $repository
     */
    public function __construct( ActivityRepository $repository,PaymentActivityRepository $activityRepository)
    {
        $this->repository = $repository;
        $this->paymentActivity = $activityRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $type = PaymentActivity::TYPES[$type];
        $activities = $this->repository
            ->scopeQuery(function (Activity &$model) use($type) {
            $model = $model->with(['paymentActivities', 'orders'])
                ->whereHas('paymentActivities', function (Builder $query) use($type){
                    return $query->where('payment_activities.type', $type);
                });
            $model->withCount(['orders as order_count', 'customers as customer_count'=> function(Builder $query) {
                    return $query->select([DB::raw('count(distinct `orders`.`customer_id`)')]);
                }]);
            $model->withSum('orders as payment_amount', function (Builder $query) {
                $query->select([DB::select('sum(orders.payment_amount)')])
                    ->whereIn('orders.status', [Order::PAID, Order::SEND, Order::COMPLETED]);
            });
            return $model;
        })->paginate();
        return $this->response()->paginator($activities, new OrderGiftItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderGiftCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(OrderGiftCreateRequest $request)
    {
        $activity = $request->all();
        $activity['app_id'] =  app(AppManager::class)->getAppId();
        $activity['status'] =  Activity::NOT_BEGINNING;
        $activity['poster_img'] = isset($activity['poster_img']) ? $activity['poster_img'] : '';
        $activity['description'] = isset($activity['description']) ? $activity['description'] : '';
        //创建一个支付活动
        $activityCreate = $this->repository->create($activity);

        $paymentActivities = [];
        foreach ($activity['payment_activity'] as $k => $v){
            $paymentActivities[$k]['activity_id']  = $activityCreate['id'];
            $paymentActivities[$k]['type']         = $v['type'];
            $paymentActivities[$k]['ticket_id']    = isset($v['ticket_id']) ? $v['ticket_id'] : null;
            $paymentActivities[$k]['discount']     = isset($v['discount']) ? $v['discount'] : null;
            $paymentActivities[$k]['cost']         = isset($v['cost']) ? $v['cost'] : null;
            $paymentActivities[$k]['least_amount'] = isset($v['least_amount']) ? $v['least_amount'] : null;
            $paymentActivities[$k]['score']        = isset($v['score']) ? $v['score'] : null;
            $paymentActivities[$k]['created_at']   = date('Y-m-d H:i:s');
            $paymentActivities[$k]['updated_at']   = date('Y-m-d H:i:s');
        }
        //支付活动对应子活动条件创建
        DB::table('payment_activity')->insert($paymentActivities);
        return $this->response()->item($activityCreate, new OrderGiftTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->repository->find($id)->first();
        return $this->response()->item($activity, new OrderGiftTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderGift = $this->repository->find($id);

        return view('orderGifts.edit', compact('orderGift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderGiftUpdateRequest $request
     * @param  string            $id
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function update(OrderGiftUpdateRequest $request, $id)
    {
        //根据活动id查询创建的活动
        $activityPayment = $this->repository->find($id);
        if ($activityPayment['start_at'] < date("Y-m-d H:i:s",time())){
            return $this->response(new JsonResponse(['message' => '活动已开始不能修改']));
        }else{
            $activity = $request->all();
            $activity['status'] =  Activity::NOT_BEGINNING;
            $activity['poster_img'] = isset($activity['poster_img']) ? $activity['poster_img'] : '';
            $activity['description'] = isset($activity['description']) ? $activity['description'] : '';
            //根据活动id修改创建的活动
            $activityUpdate = $this->repository->update($activity,$id);

            //根据活动id查询此活动下子活动的原始数据
            $payments = $this->paymentActivity->findWhere(['activity_id'=>$activityPayment['id']]);
            $paymentDeleteIds = [];
            foreach ($payments as $k => $v){
                $paymentDeleteIds[$k] = $v['id'];
            }
            //删除此活动下子活动的数据
            PaymentActivity::destroy($paymentDeleteIds);

            //根据更新的活动id创建此活动下子活动的数据
            $paymentActivities = [];
            foreach ($activity['payment_activity'] as $k => $v){
                $paymentActivities[$k]['activity_id']  = $id;
                $paymentActivities[$k]['type']         = $v['type'];
                $paymentActivities[$k]['ticket_id']    = isset($v['ticket_id']) ? $v['ticket_id'] : null;
                $paymentActivities[$k]['discount']     = isset($v['discount']) ? $v['discount'] : null;
                $paymentActivities[$k]['cost']         = isset($v['cost']) ? $v['cost'] : null;
                $paymentActivities[$k]['least_amount'] = isset($v['least_amount']) ? $v['least_amount'] : null;
                $paymentActivities[$k]['score']        = isset($v['score']) ? $v['score'] : null;
                $paymentActivities[$k]['created_at']   = date('Y-m-d H:i:s');
                $paymentActivities[$k]['updated_at']   = date('Y-m-d H:i:s');
            }
            //创建子活动
            DB::table('payment_activity')->insert($paymentActivities);
            return $this->response()->item($activityUpdate, new OrderGiftTransformer());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        //根据活动id查询创建的活动
        $activityPayment = $this->repository->find($id);
        //根据活动id查询此活动下子活动的原始数据
        $payments = $this->paymentActivity->findWhere(['activity_id'=>$activityPayment['id']]);
        $paymentDeleteIds = [];
        foreach ($payments as $k => $v){
            $paymentDeleteIds[$k] = $v['id'];
        }
        //删除此活动下子活动的数据
        PaymentActivity::destroy($paymentDeleteIds);
        return $this->response(new JsonResponse(['delete_count' => $deleted]));
    }
}
