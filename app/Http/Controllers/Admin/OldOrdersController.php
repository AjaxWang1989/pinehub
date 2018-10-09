<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\OrderRepositoryEloquent;
use App\Transformers\OrderDetailTransformer;
use App\Transformers\OrdersTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;

class OldOrdersController extends Controller
{
    protected $orderModel = null;

    public function __construct(OrderRepositoryEloquent $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    /**
     * 订单列表
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function getOrders(Request $request)
    {
        $this->orderModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->orderModel->with(['buyer', 'orderItems'])
            ->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($result, new OrdersTransformer());
    }

    /**
     * 订单详情
     * @param int $id
     * @return Response
     * */
    public function getOrderDetail(int $id)
    {
        $shop = $this->orderModel->with(['buyer', 'orderItems'])->find($id);
        if(!$shop){
            $this->response()->errorNotFound('没有找到对应的店铺信息');
        }
        return $this->response()->item($shop, new OrderDetailTransformer());
    }
}
