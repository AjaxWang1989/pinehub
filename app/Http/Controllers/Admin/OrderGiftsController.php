<?php

namespace App\Http\Controllers\Admin;

use App\Entities\OrderGift;
use App\Http\Response\JsonResponse;

use Exception;
use App\Http\Requests\Admin\OrderGiftCreateRequest;
use App\Http\Requests\Admin\OrderGiftUpdateRequest;
use App\Transformers\OrderGiftTransformer;
use App\Transformers\OrderGiftItemTransformer;
use App\Repositories\OrderGiftRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * Class OrderGiftsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class OrderGiftsController extends Controller
{
    /**
     * @var OrderGiftRepository
     */
    protected $repository;


    /**
     * OrderGiftsController constructor.
     *
     * @param OrderGiftRepository $repository
     */
    public function __construct(OrderGiftRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Request::input('type');
        $orderGifts = $this->repository->scopeQuery(function (OrderGift &$model) use($type) {
            $model = $model->whereType($type);
            $beginAt = Request::input('begin_at', null);
            $endAt = Request::input('end_at', null);
            if($beginAt) {
                $model = $model->where('begin_at', '>=', $beginAt);
            }

            if($endAt) {
                $model = $model->where('end_at', '<', $endAt);
            }
            Log::debug('order gift type '.$type);
            return $model;
        })->paginate();
        return $this->response()->paginator($orderGifts, new OrderGiftItemTransformer());
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

       $response = [
           'message' => 'OrderGift updated.',
           'data'    => $orderGift->toArray(),
       ];

       if ($request->wantsJson()) {

           return $this->response()->item($orderGift, new OrderGiftTransformer());
       }

       return redirect()->back()->with('message', $response['message']);
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
                'message' => 'OrderGift deleted.',
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', 'OrderGift deleted.');
    }
}
