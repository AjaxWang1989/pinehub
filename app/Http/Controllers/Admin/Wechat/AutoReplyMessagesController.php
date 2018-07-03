<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Criteria\Admin\WechatAutoReplyMessageCriteria;
use App\Entities\WechatAutoReplyMessage;
use App\Http\Requests\Admin\Wechat\AutoReplyMessageCreateRequest;
use App\Http\Requests\Admin\Wechat\AutoReplyMessageUpdateRequest;
use App\Repositories\WechatAutoReplyMessageRepository;
use App\Http\Controllers\Controller;
use App\Services\AppManager;
use App\Transformers\WechatAutoReplyMessageItemTransformer;
use App\Transformers\WechatAutoReplyMessageTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class AutoReplyMessagesController extends Controller
{
    //
    /**
     * @var WechatAutoReplyMessageRepository
     */
    protected $repository;


    /**
     * MaterialsController constructor.
     *
     * @param WechatAutoReplyMessageRepository $repository
     */
    public function __construct(WechatAutoReplyMessageRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(WechatAutoReplyMessageCriteria::class);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return Response|DingoResponse
     * @throws
     */
    public function index()
    {
        $autoReplyMessages = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($autoReplyMessages, new WechatAutoReplyMessageItemTransformer());
        }

        return view('materials.index', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AutoReplyMessageCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(AutoReplyMessageCreateRequest $request)
    {
        $autoReplyMessage = $this->repository->create($request->all());

        $response = [
            'message' => '成功创建小程序或者公众号配置信息.',
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($autoReplyMessage, new WechatAutoReplyMessageTransformer());
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
        $material = $this->repository->find($id);

        if (request()->wantsJson()) {

            return $this->response()->item($material, new WechatAutoReplyMessageItemTransformer());
        }

        return view('materials.show', compact('material'));
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
        $material = $this->repository->find($id);

        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AutoReplyMessageUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws
     */
    public function update(AutoReplyMessageUpdateRequest $request, $id)
    {
        $material = $this->repository->update($request->all(), $id);

        $response = [
            'message' => '小程序或者公众号信息修改成功.',
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($material, new WechatAutoReplyMessageTransformer());
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
        $message = "删除指定配置信息。";
        if (request()->wantsJson()) {

            return $this->response(new JsonResponse([
                'message' => $message,
                'deleted' => $deleted,
            ]));
        }

        return redirect()->back()->with('message', $message);
    }
}
