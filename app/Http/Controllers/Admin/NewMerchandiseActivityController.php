<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\NewActivityImageRequest;
use App\Http\Requests\Admin\NewActivityMerchandiseRequest;
use App\Http\Requests\Admin\NewActivityMerchandiseStockRequest;
use App\Http\Requests\Admin\NewActivityRequest;
use App\Repositories\ActivityMerchandiseRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\FileRepository;
use App\Services\AppManager;
use App\Http\Controllers\FileManager\UploadController as Controller;
use App\Transformers\ActivityTransformer;

class NewMerchandiseActivityController extends Controller
{
    protected $activityRepository = null;

    protected $merchandiseRepository = null;
    public function __construct(FileRepository $fileModel, ActivityRepository $activityRepository,
                                ActivityMerchandiseRepository $merchandiseRepository)
    {
        parent::__construct($fileModel);
        $this->activityRepository = $activityRepository;
        $this->merchandiseRepository = $merchandiseRepository;
    }

    //
    public function storeActivity(NewActivityRequest $request)
    {
        $activity = $this->activityRepository->create($request->all());
        return $this->response()->item($activity, new ActivityTransformer());
    }

    public function uploadImage(NewActivityImageRequest $request, string $driver="default")
    {
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $request->request->set('dir', "{$appId}/newMerchandiseActivity");
        return $this->upload($request, $driver);
    }

    public function addMerchandise(int $activityId, NewActivityMerchandiseRequest $request)
    {

    }

    public function updateStock(int $id, NewActivityMerchandiseStockRequest $request)
    {

    }
}
