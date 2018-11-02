<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Entities\WechatMenu;
use App\Exceptions\WechatMenuDeleteException;
use App\Http\Controllers\Admin\ControllerTrait;
use App\Http\Requests\Admin\Wechat\MenuUpdateRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\AppRepository;
use App\Services\AppManager;
use App\Transformers\WechatMenuTransformer;
use Dingo\Api\Http\Request;
use App\Http\Requests\Admin\Wechat\MenuCreateRequest;
use App\Repositories\WechatMenuRepository;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

/**
 * Class MenusesController.
 *
 * @package namespace App\Http\Controllers\Admin\Wechat;
 */
class MenuController extends Controller
{
    use ControllerTrait;
    /**
     * @var MenusRepository
     */
    protected $repository;


    /**
     * MenusesController constructor.
     *
     * @param WechatMenuRepository $repository
     * @param Request $request
     * @param AppRepository $appRepository
     * @throws
     */
    public function __construct(WechatMenuRepository $repository, Request $request, AppRepository $appRepository)
    {
        $this->repository = $repository;
        parent::__construct();
        $this->parseApp($request, $appRepository);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuses = $this->repository->paginate();
        return $this->response()->paginator($menuses, new WechatMenuTransformer());
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
        $menu = $request->only(['menus', 'name']);
        $menu = $this->repository->create($menu);
        return $this->response()->item($menu, new WechatMenuTransformer());
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
        return $this->response()->item($menu, new WechatMenuTransformer());
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
     * Update the specified resource in storage.
     *
     * @param  MenuUpdateRequest $request
     * @param  int            $id
     *
     * @return Response|RedirectResponse
     *
     * @throws
     */
    public function update(MenuUpdateRequest $request, $id)
    {
        $menu = $this->repository->update($request->all(), $id);
        if(!$menu)
            throw new ModelNotFoundException('菜单查找失败，没有相应的菜单数据！', 'MENU_NOT_FOUND');
        return $this->response()->item($menu, new WechatMenuTransformer());
    }


    /**
     * @param int|array $id
     * @return Response
     * */
    public function sync($id)
    {
        $menu = $this->repository->update(['is_public' => true], $id);
        if(!$menu)
            throw new ModelNotFoundException('菜单查找失败，没有相应的菜单数据！', 'MENU_NOT_FOUND');
        return $this->response(new JsonResponse(['message' => '数据与微信同步成功！']));
    }


    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws
     * */
    public function destroy(Request $request, int $id = null)
    {
        $count = 0;
        if($id === null) {
            $id = $request->input('ids');
        }
        if(is_array($id)){
            $deleted = $this->repository->findWhere([
                'is_publish' => false,
                ['id' , 'in', $id],
                'app_id' => app(AppManager::class)->officialAccount->appId
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
        return $this->response(new JsonResponse([
            'message' => $message,
            'deleted' => $deleted,
        ]));
    }

    public function __destruct()
    {
        $this->repository = null;
        parent::__destruct(); // TODO: Change the autogenerated stub
    }
}
