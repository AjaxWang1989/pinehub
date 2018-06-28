<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Entities\WechatConfig;
use App\Http\Requests\Admin\Wechat\ConfigCreateRequest;
use App\Http\Requests\Admin\Wechat\ConfigUpdateRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\WechatConfigRepository;
use App\Services\AppManager;
use App\Transformers\WechatConfigItemTransformer;
use App\Transformers\WechatConfigTransformer;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class ConfigController extends Controller
{
    /**
     * @var MaterialsRepository
     */
    protected $repository;

    /**
     * @var AppManager
     * */
    protected $appManager;


    /**
     * MaterialsController constructor.
     *
     * @param WechatConfigRepository $repository
     */
    public function __construct(WechatConfigRepository $repository, AppManager $appManager)
    {
        $this->repository = $repository;
        $this->appManager = $appManager;
    }

    /**
     * Display a listing of the resource.
     * @return Response|DingoResponse
     */
    public function index()
    {
        $materials = $this->repository->paginate();

        if (request()->wantsJson()) {

            return $this->response()->paginator($materials, new WechatConfigItemTransformer());
        }

        return view('materials.index', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(ConfigCreateRequest $request)
    {
        $material = $this->repository->create($request->all());

        $response = [
            'message' => '成功创建小程序或者公众号配置信息.',
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($material, new WechatConfigTransformer());
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

            return $this->response()->item($material, new WechatConfigTransformer());
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
     * @param  ConfigUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws
     */
    public function update(ConfigUpdateRequest $request, $id)
    {
        $material = $this->repository->update($request->all(), $id);

        $response = [
            'message' => '小程序或者公众号信息修改成功.',
        ];

        if ($request->wantsJson()) {

            return $this->response()->item($material, new WechatConfigTransformer());
        }

        return redirect()->back()->with('message', $response['message']);
    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param  int|array $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        $count = 0;
        if($id === null) {
            $id = $request->input('ids');
        }
        if(is_array($id)){
            $deleted = $this->repository->findWhereIn('id', $id);
            tap($deleted, function (Collection $deleted) use( &$count ){
                $deleted->map(function (WechatConfig $config) use ( &$count ){
                    $config->delete();
                    $count ++;
                });
            });
            $deleted = $count;
        }else {
            $deleted = $this->repository->delete($id);
        }

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
