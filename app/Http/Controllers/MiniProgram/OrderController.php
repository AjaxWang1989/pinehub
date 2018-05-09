<?php

namespace App\Http\Controllers\MiniProgram;

use App\Entities\Order;
use App\Entities\OrderItem;
use App\Repositories\OrderRepositoryEloquent;
use App\Transformers\Api\OrderTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    //
    protected $orderModel = null;

    public function __construct(OrderRepositoryEloquent $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    /**
     * @param Request $request
     * @return  Response
     * @throws
     * */
    public function store(Request $request)
    {
        $order = $request->only([]);
        $orderItems = collect($request->get('orderItems'));
        $order = $this->orderModel->create($order);
        $orderItems = $this->createOrderItems($orderItems);
        $order->orderItems()->saveMany($orderItems);
        return $this->response()->item($order, new OrderTransformer());
    }

    protected function createOrderItems(Collection $orderItems)
    {
        return $orderItems->map(function ($item){
            return new OrderItem($item);
        });
    }

    public function getOrders($status = null)
    {
        $this->orderModel->scopeQuery(function (Order $order) use($status){
            $order->where('buyer_user_id', $this->user()->id);
            return $status ? $order->where('status', $status) : $order;
        });
        $orders = $this->orderModel->paginate(PAGE_LIMIT);
        return $this->response()->paginator($orders, new OrderTransformer());
    }
}
