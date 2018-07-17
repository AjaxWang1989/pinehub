<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\OrderCriteria;
use App\Criteria\Admin\OrderSearchCriteria;
use App\Entities\Order;
use App\Http\Requests\OrderSendRequest;
use App\Http\Response\JsonResponse;

use Dingo\Api\Http\Request;
use Exception;
use App\Http\Requests\Admin\OrderCreateRequest;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Transformers\OrderTransformer;
use App\Transformers\OrderItemTransformer;
use App\Repositories\OrderRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    protected $repository;


    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(OrderCriteria::class);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(OrderSearchCriteria::class);
        $orders = $this->repository->with(['orderItems.orderMerchandise',
            'orderItems.shop', 'orderItems.customer', 'customer', 'member'])->paginate(\Illuminate\Support\Facades\Request::input('limit', PAGE_LIMIT));

        if (request()->wantsJson()) {

            return $this->response()->paginator($orders, new OrderItemTransformer());
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(OrderCreateRequest $request)
    {
        $order = $this->repository->create($request->all());

        $response = [
            'message' => 'Order created.',
            'data'    => $order->toArray(),
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($order, new OrderTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
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
        $order = $this->repository->with(['orderItems.orderMerchandise', 'orderItems.shop', 'customer', 'member'])->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($order, new OrderTransformer());
        }

        return view('orders.show', compact('order'));
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
        $order = $this->repository->find($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws Exception
     */
    public function update(OrderUpdateRequest $request, $id)
    {
       $order = $this->repository->update($request->all(), $id);

       $response = [
           'message' => 'Order updated.',
           'data'    => $order->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($order, new OrderTransformer());
       }

       return redirect()->back()->with('message', $response['message']);
    }

    public function orderSent(OrderSendRequest $request, int $id)
    {
        $order = $this->repository->with(['orderItems'])->find($id);
        DB::transaction(function () use($order, $request) {
            tap($order, function (Order $order) use($request){
                $order->status = Order::SEND;
                $order->postType = $request->input('post_type', null);
                $order->postNo = $request->input('post_no', null);
                $order->postName = $request->input('post_name', null);
                $order->consignedAt = Carbon::now();
                $order->orderItems()->update(['status' => Order::SEND, 'consigned_at' => $order->consignedAt]);
                $order->save();
            });
        });

        return $this->response()->item($order, new OrderTransformer());

    }


    public function refund(int $id)
    {
        $order = $this->repository->with(['orderItems'])->find($id);
        if($order) {

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

        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => 'Order deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'Order deleted.');
    }
}
