<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\OrderCriteria;
use App\Criteria\Admin\OrderSearchCriteria;
use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Order;
use App\Entities\OrderItem;
use App\Exceptions\HttpValidationException;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;


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

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $this->repository->pushCriteria(OrderSearchCriteria::class);
        $this->repository->pushCriteria(OrderCriteria::class);
        $this->repository->pushCriteria(SearchRequestCriteria::class);
        $orders = $this->repository
            ->with(['orderItems.merchandise', 'orderItems.shop', 'customer', 'member', 'activity', 'receivingShopAddress'])
            ->scopeQuery(function ($query) {
                return $query->whereHas('customer');
            })
            ->orderBy('paid_at', 'desc')
            ->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($orders, new OrderItemTransformer());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     * @throws \Maatwebsite\Excel\Exceptions\LaravelExcelException
     */
    public function downloadExcel(Request $request)
    {
        $this->repository->pushCriteria(OrderCriteria::class);
        $this->repository->pushCriteria(SearchRequestCriteria::class);
        $orders = $this->repository
            ->with(['orderItems.merchandise', 'orderItems.shop', 'customer', 'member', 'activity', 'receivingShopAddress', 'shop', 'tickets'])
            ->scopeQuery(function ($query) {
                return $query->whereHas('customer');
            })
            ->orderBy('paid_at', 'desc')
            ->all();
        $header = $request->input('header',  [
            '支付订单号',
            '商户名称',
            '店铺名称',
            '店铺编号',
            '买家姓名',
            '买家手机',
            '下单时间',
            '交易渠道',
            '订单类型',
            '产品名称',
            '产品数',
            '售价',
            '优惠券',
            '优惠金额',
            '实付'
        ]);
        if(!$header || empty($header)) {
            throw new HttpValidationException(['缺少头部信息错误']);
        }
        $list  = [];
        $list[] = $header;
        $data = with($orders, function (Collection $orders) use (& $list){
            $orders->map(function (Order $order) use (& $list){
                $order->orderItems->map(function (OrderItem $item) use($order, & $list){
                    $shop = $item->shop ? $item->shop : ($order->shop ? $order->shop : $order->receivingShopAddress);
                    $nickname= ($order->customer && $order->customer->nickname ? $order->customer->nickname : '匿名用户');
                    $mobile = $order->customer && $order->customer->mobile ? $order->customer->mobile : '未绑定手机';
                    $paidAt = $order->paidAt ? $order->paidAt->format('m/d/Y') : '--';
                    $list[] = [
                        "'$order->code",
                        '安徽青松食品有限公司',
                         $shop ? $shop->name : '--',
                         $shop ? $shop->code : '--',
                         $nickname,
                        "'$mobile",
                         $paidAt,
                         $order->payTypeStr(),
                         $order->orderTypeStr(),
                         $item->merchandiseName,
                         $item->quality,
                         $item->sellPrice,
                         $order->tickets ? $order->tickets->cardInfo['base_info']['title'] : '--',
                         number_format($order->discountAmount, 2),
                         number_format($order->paymentAmount, 2)
                    ];
                });
               //return $items->toArray();
            });
            //Log::debug('order items', $orderItems->toArray());
            return $list;
        });
        Log::debug('order excel data', [$data, $list]);
        /** @var LaravelExcelWriter $excel */
        $excel = app(Excel::class)->create(Carbon::now()->format('Y-m-d').'订单', function(LaravelExcelWriter $excel) use ($data) {

            $excel->sheet('Sheet', function(LaravelExcelWorksheet $sheet) use ($data) {

                // Sheet manipulation
                $sheet->rows($data);

            });

        });

        $excel->export();
#
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
        $order = $this->repository->with(['orderItems.merchandise', 'orderItems.shop', 'customer', 'member'])->find($id);
        return $this->response()->item($order, new OrderTransformer());
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
     * @return \Illuminate\Http\Response
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
        return $this->response(new JsonResponse(['delete_count' => $deleted]));
    }
}
