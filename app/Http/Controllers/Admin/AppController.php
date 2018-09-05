<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/28
 * Time: 上午10:33
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\FileManager\UploadController as Controller;
use App\Http\Requests\Admin\AppCreateRequest;
use App\Http\Requests\Admin\AppUpdateRequest;
use App\Http\Response\JsonResponse;
use App\Repositories\AppRepository;
use App\Repositories\FileRepository;
use App\Http\Requests\Admin\AppLogoImageRequest;
use App\Transformers\AppItemTransformer;
use App\Transformers\AppTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppController extends Controller
{
    //定义repository 处理model层数据
    protected $appRepository  = null;
    public function __construct(FileRepository $fileModel, AppRepository $appRepository)
    {
        parent::__construct($fileModel);
        $this->appRepository = $appRepository;
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
        $item = $this->appRepository->find($id);
        return $this->response()->item($item, new AppTransformer());
    }

    public function destroy(string $id)
    {
        $result = $this->appRepository->delete($id);
        return $this->response(new JsonResponse(['delete_count' => $result]));
    }

}