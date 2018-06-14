<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Entities\WechatMenu;
use App\Exceptions\WechatMenuDeleteException;
use App\Http\Response\JsonResponse;
use App\Transformers\WechatMenuTransformer;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Admin\Wechat\MenuCreateRequest;
use App\Repositories\WechatMenuRepository;
use App\Http\Controllers\Controller;
/**
 * Class MenusesController.
 *
 * @package namespace App\Http\Controllers\Admin\Wechat;
 */
class MenuController extends Controller
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
     * @param string $appId
     * @return \Illuminate\Http\Response
     */
    public function index(string $appId = null)
    {
        if($appId){
            $this->repository->scopeQuery(function (Builder $query) use ($appId) {
                return $query->where('app_id', $appId);
            });
        }
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
        $menu = $this->repository->create(['app_id' => $this->currentWechat->appId, 'menus'  => $request->all()]);

        if ($request->wantsJson()) {
            return $this->response()->item($menu, new WechatMenuTransformer());
        }

        return redirect()->back()->with('message', '菜单保存成功');
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
        $menu = $this->repository->find($id);
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



    public function sync($id)
    {
        $menu = $this->repository->find($id);

        tap($menu, function (WechatMenu $menu) {
            $buttons = $menu->menus;
            $result = app('wechat')->officeAccount()->menu->create($buttons);
            if($result['errcode'] !== 0) {
                $this->response()->error($result['errmsg']);
            }
        });

        return $this->response(new JsonResponse(['message' => '数据与微信同步成功！']));
    }

    public function destroy(Request $request, $id = null)
    {
        $count = 0;
        if($id === null) {
            $id = $request->input('ids');
        }
        if(is_array($id)){
            $deleted = $this->repository->findWhere([
                'is_publish' => false,
                ['id' , 'in', $id]
            ]);
            $idCount = count($id);
            $deletedCount = $deleted->count();
            if($idCount === $deletedCount) {
                throw new WechatMenuDeleteException('批量删除的菜单中有发布过的菜单不能删除，请确定后再操作');
            }
            tap($deleted, function (Collection $deleted) use( &$count ){
                $deleted->map(function (WechatMenu $config) use ( &$count ){
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