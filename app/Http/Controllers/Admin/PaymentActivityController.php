<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Activity;
use App\Entities\Order;
use App\Entities\PaymentActivity;
use App\Exceptions\TicketSyncException;
use App\Exceptions\UpdateActivityFailed;
use App\Http\Response\JsonResponse;
use App\Services\AppManager;
use Carbon\Carbon;
use Exception;
use App\Http\Requests\Admin\OrderGiftCreateRequest;
use App\Http\Requests\Admin\OrderGiftUpdateRequest;
use App\Transformers\OrderGiftTransformer;
use App\Transformers\OrderGiftItemTransformer;
use App\Repositories\ActivityRepository;
use App\Repositories\PaymentActivityRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param PaymentActivityRepository $activityRepository
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
        $this->repository->pushCriteria(app(SearchRequestCriteria::class));
        $activities = $this->repository
            ->withCount(['orders as order_count', 'customers as customer_count'=> function(Builder $query) {
                return $query->select([DB::raw('count(distinct `orders`.`customer_id`)')]);
            }])
            ->withSum('orders as payment_amount', function (Builder $query) {
                return $query->select([DB::select('sum(orders.payment_amount)')])
                    ->whereIn('orders.status', [Order::PAID, Order::SEND, Order::COMPLETED]);
            })
            ->scopeQuery(function ($model) use($type) {
                return $model->with(['paymentActivities', 'orders'])
                    ->whereHas('paymentActivities', function (Builder $query) use($type){
                        return $query->where('payment_activities.type', $type);
                    });
            })->paginate();
        return $this->response()->paginator($activities, new OrderGiftItemTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderGiftCreateRequest $request
     *
     * @param string $type
     * @return \Illuminate\Http\Response
     *
     */
    public function store(OrderGiftCreateRequest $request, string $type = 'coupon')
    {
        $activity = $request->only(['title', 'start_at', 'end_at']);
        $activity['app_id'] =  app(AppManager::class)->getAppId();
        if(Carbon::parse($activity['start_at'])->timestamp <= Carbon::now(config('app.timezone'))->timestamp) {
            $activity['status'] =  Activity::HAVE_IN_HAND;
        }elseif(Carbon::parse($activity['start_at'])->timestamp > Carbon::now(config('app.timezone'))->timestamp){
            $activity['status'] =  Activity::NOT_BEGINNING;
        }

        $activity['poster_img'] = isset($activity['poster_img']) ? $activity['poster_img'] : '';
        $activity['description'] = isset($activity['description']) ? $activity['description'] : '';
        //创建一个支付活动
        /** @var Activity $activityModel */
        $activityModel = $this->repository->create($activity);

        $items = $request->only(['items']);
        $paymentActivities = [];
        foreach ($items as $v){
            $item['type']         = PaymentActivity::TYPES[$type];
            $item['ticket_id']    = isset($v['ticket_id']) ? $v['ticket_id'] : 0;
            $item['discount']     = isset($v['discount']) ? $v['discount'] : 0;
            $item['cost']         = isset($v['cost']) ? $v['cost'] : 0;
            $item['least_amount'] = isset($v['least_amount']) ? $v['least_amount'] : 0;
            $item['score']        = isset($v['score']) ? $v['score'] : 0;
            $item['ticket_count']        = isset($v['ticket_count']) ? $v['ticket_count'] : 0;
            array_push($paymentActivities, new PaymentActivity($item));
        }
        //支付活动对应子活动条件创建
        $activityModel->paymentActivities()->saveMany($paymentActivities);
        return $this->response()->item($activityModel, new OrderGiftTransformer());
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
        $activity = $this->repository->find($id);
        if($activity) {
            return with($activity, function (Activity $activity) use($request) {
                if ($activity->startAt->getTimestamp() < time()){
                    throw new UpdateActivityFailed('活动已开始不能修改', ACTIVITY_RUN_CANNOT_UPDATE);
                }else{
                    $activity->status =  Activity::NOT_BEGINNING;
                    $activity->title = $request->input('title');
                    $activity->startAt = Carbon::createFromFormat(config('app.timezone'), $request->input('start_at'));
                    $activity->endAt = Carbon::createFromFormat(config('app.timezone'), $request->input('end_at'));
                    $activity->save();
                    //根据活动id修改创建的活动
                    $activity->paymentActivities()->update($request->input('items'));
                    return $this->response()->item($activity, new OrderGiftTransformer());
                }
            });
        }else{
            throw new ModelNotFoundException('活动不存在');
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
