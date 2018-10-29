<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Activity;
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


    /**
     * PaymentActivityController constructor.
     *
     * @param ActivityRepository $repository
     */
    public function __construct( ActivityRepository $repository)
    {
        $this->repository = $repository;
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
            $model = $model->with(['paymentActivities'])
                ->whereHas('paymentActivities', function (Builder $query) use($type){
                return $query->where('type', $type);
            });
            $model->withCount(['orders as order_count', 'customers as customer_count'=> function(Builder $query) {
                return $query->select([DB::raw('count(distinct `orders`.`customer_id`)')]);
            }]);
            return $model;
        })->paginate();
//        return app(AppManager::class)->getAppId();
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
        $data = $request->all();
        $orderGift = $this->repository->create($data);
        return $this->response()->item($orderGift, new OrderGiftTransformer());
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
        $orderGift = $this->repository->find($id);
        return $this->response()->item($orderGift, new OrderGiftTransformer());
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
       $orderGift = $this->repository->update($request->all(), $id);
        return $this->response()->item($orderGift, new OrderGiftTransformer());
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
        return $this->response(new JsonResponse(['delete_count' => $deleted]));
    }
}
