<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Repositories\WechatMaterialRepository;
use App\Transformers\WechatMaterialItemTransformer;
use App\Transformers\WechatMaterialTransformer;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Http\Response as DingoResponse;
use \Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Wechat\MaterialsCreateRequest;
use App\Http\Requests\Admin\Wechat\MaterialsUpdateRequest;
use App\Http\Controllers\Controller;

/**
 * Class MaterialsController.
 *
 * @package namespace App\Http\Controllers\Admin\Wechat;
 */
class MaterialController extends Controller
{
    /**
     * @var MaterialsRepository
     */
    protected $repository;

    /**
     * MaterialsController constructor.
     *
     * @param WechatMaterialRepository $repository
     */
    public function __construct(WechatMaterialRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response|DingoResponse
     */
    public function index(Request $request)
    {
        $materials = $this->repository->paginate($request->input('limit', PAGE_LIMIT));

        if (request()->wantsJson()) {

            return $this->response()->paginator($materials, new WechatMaterialItemTransformer());
        }

        return view('materials.index', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(MaterialsCreateRequest $request)
    {
        try {

            $material = $this->repository->create($request->all());

            $response = [
                'message' => 'Materials created.',
            ];

            if ($request->wantsJson()) {

                return $this->response()->item($material, new WechatMaterialTransformer());
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidationHttpException $e) {
            if ($request->wantsJson()) {
                return $this->response()->error($e->getMessageBag());
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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

            return $this->response()->item($material, new WechatMaterialTransformer());
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
     * @param  MaterialsUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws
     */
    public function update(MaterialsUpdateRequest $request, $id)
    {
        try {

            $material = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Materials updated.',
            ];

            if ($request->wantsJson()) {

                return $this->response()->item($material, new WechatMaterialTransformer());
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidationHttpException $e) {

            if ($request->wantsJson()) {

                return $this->response()->error($e->getMessageBag());
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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

            return $this->response()->json([
                'message' => 'Materials deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Materials deleted.');
    }
}
