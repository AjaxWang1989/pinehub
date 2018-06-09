<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Transformers\WechatMenuTransformer;
use Dingo\Api\Exception\ValidationHttpException;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\Admin\Wechat\MenuCreateRequest;
use App\Http\Requests\Admin\Wechat\MenuUpdateRequest;
use App\Repositories\WechatMenuRepository;
use App\Http\Controllers\Controller;
/**
 * Class MenusesController.
 *
 * @package namespace App\Http\Controllers\Admin\Wechat;
 */
class MenusesController extends Controller
{
    /**
     * @var MenusRepository
     */
    protected $repository;



    /**
     * MenusesController constructor.
     *
     * @param WechatMenuRepository $repository
     */
    public function __construct(WechatMenuRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $menuses = $this->repository->paginate();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $menuses,
            ]);
        }
        return view('menuses.index', compact('menuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(MenuCreateRequest $request)
    {
        try {
            $result = app('wechat')->officeAccount()->menu->create($request->all());
            if($result['errcode'] === 0){
                $menu = $this->repository->updateOrCreate(['app_id' => $this->currentWechat->appId], [ 'menus'  => $request->all()]);

                if ($request->wantsJson()) {
                    return $this->response()->item($menu, new WechatMenuTransformer());
                }

                return redirect()->back()->with('message', $result['errmsg']);
            }else{
                if ($request->wantsJson()) {
                    return $this->response()->error($result['errmsg']);
                }

                return redirect()->back()->with('message', $result['errmsg']);
            }

        } catch (ValidationHttpException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
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
    public function show($id = null)
    {
        $menus = $this->repository->findWhere(['app_id' => $this->currentWechat->appId]);
        $menu = $menus->first();
        if (request()->wantsJson()) {

            return $this->response()->item($menu);
        }

        return view('menuses.show', compact('menu'));
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
        $menu = $this->repository->find($id);

        return view('menuses.edit', compact('menu'));
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

            return response()->json([
                'message' => 'Menus deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Menus deleted.');
    }
}
