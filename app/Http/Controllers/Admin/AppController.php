<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/28
 * Time: 上午10:33
 */

namespace App\Http\Controllers\Admin;


use App\Entities\App;
use App\Entities\Role;
use App\Entities\Shop;
use App\Http\Controllers\FileManager\UploadController as Controller;
use App\Http\Requests\Admin\AppCreateRequest;
use App\Http\Requests\Admin\AppUpdateRequest;
use App\Http\Requests\Admin\SetMpConfigRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\AppRepository;
use App\Repositories\FileRepository;
use App\Http\Requests\Admin\AppLogoImageRequest;
use App\Repositories\MiniProgramRepository;
use App\Services\AppManager;
use App\Transformers\AppItemTransformer;
use App\Transformers\AppTransformer;
use App\Transformers\SevenDaysStatisticsTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    use ControllerTrait;
    //定义repository 处理model层数据
    protected $appRepository  = null;

    protected $miniProgramRepository = null;

    public function __construct(FileRepository $fileModel, AppRepository $appRepository, MiniProgramRepository $miniProgramRepository, Request $request)
    {
        parent::__construct($fileModel);
        $this->appRepository = $appRepository;
        $this->miniProgramRepository = $miniProgramRepository;
        //$this->parseApp($request, $appRepository);
    }

    public function uploadLogo(AppLogoImageRequest $request, string $driver = "default")
    {
        return parent::upload($request, $driver); // TODO: Change the autogenerated stub
    }

    public function store(AppCreateRequest $request)
    {
        $item = $this->appRepository->create($request->all());
        return $this->response()->item($item, new AppTransformer());
    }

    public function index(Request $request)
    {
        $items = $this->appRepository->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($items, new AppItemTransformer());
    }

    public function update(string $id, AppUpdateRequest $request)
    {
        $result = $this->appRepository->update($request->all(), $id);
        return $this->response()->item($result, new AppTransformer());
    }

    public function show(string $id)
    {
        $time = Carbon::today(config('app.timezone'))
            ->startOfDay()
            ->subDay(7);

        $start = Carbon::today(config('app.timezone'))
            ->startOfDay()
            ->subDay(1);
        $end = $start->copy()->endOfDay();

        $item = $this->appRepository
            ->with(['officialAccount', 'miniProgram'])
            ->withCount([
                'shops' => function (Builder $shops) {
                    return $shops->where('status', '<>', Shop::STATUS_WAIT);
                },
                'orders' => function (Builder $orders) use($time){
                    return $orders->where('paid_at', '>=', $time);
                },
                'users as new_user_count' => function(Builder $users) use($start, $end){
                    return $users->where('last_login_at', '>=', $start)
                        ->where('last_login_at', '<', $end)
                        ->whereHas('roles', function (Builder $roles) {
                        return $roles->where('slug', Role::MEMBER);
                    });
                },
                'users as active_user_count' => function(Builder $users) use($time){
                    return $users->where('last_login_at', '>=', $time)
                        ->whereHas('roles', function (Builder $roles) {
                            return $roles->where('slug', Role::MEMBER);
                        });
                }])->find($id);

        return $this->response()->item($item, new AppTransformer());
    }

    public function destroy(string $id)
    {
        $result = $this->appRepository->delete($id);
        return $this->response(new JsonResponse(['delete_count' => $result]));
    }


    /**
     * 设置小程序配置
     *
     * @param SetMpConfigRequest $request
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function setMpConfig(SetMpConfigRequest $request, int $id = null)
    {
        $app= app(AppManager::class);
        if($id) {
            $miniProject = $this->miniProgramRepository->update($request->all(), $id);
            $project = $miniProject->app;
        }else{
            $miniProject = $this->miniProgramRepository->create($request->all());
            $app->currentApp->miniAppId = $miniProject->id;
            $app->currentApp->save();
            $project = $app->currentApp;
        }

        if($project) {
            return $this->response()->item($project, new AppTransformer());
        }else {
            throw new StoreResourceFailedException('小程序配置保存失败', null, null, [], MODEL_SAVE_FAILED);
        }
    }

    public function sevenDaysStatistics()
    {
        $end = Carbon::now(config('app.timezone'));
        $start = $end->copy()->startOfWeek()->subDay(7);
        $project = app(AppManager::class)->currentApp;
        $result = $project->orders()->select([DB::raw('count(*) as count'), DB::raw('DATE_FORMAT(`paid_at`, "%w") as paid_time'), 'paid_at'])
            ->where('paid_at', '>=', $start)
            ->where('paid_at', '<', $end)
            ->groupBy('paid_time')
            ->get();
        $transformer = new SevenDaysStatisticsTransformer();
        return $this->response(new JsonResponse($transformer->transform($result)));//->item($result, new SevenDaysStatisticsTransformer());
    }

}