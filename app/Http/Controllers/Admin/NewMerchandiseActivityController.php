<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\Admin\NewMerchandiseActivityCriteria;
use App\Entities\Activity;
use App\Entities\ActivityMerchandise;
use App\Http\Requests\Admin\NewActivityImageRequest;
use App\Http\Requests\Admin\NewActivityMerchandiseRequest;
use App\Http\Requests\Admin\NewActivityMerchandiseStockRequest;
use App\Http\Requests\Admin\NewActivityRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\FileRepository;
use App\Services\AppManager;
use App\Http\Controllers\FileManager\UploadController as Controller;
use App\Transformers\ActivityTransformer;
use App\Transformers\ActivityMerchandiseTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewMerchandiseActivityController extends Controller
{
    protected $activityRepository = null;

    public function __construct(FileRepository $fileModel, ActivityRepository $activityRepository)
    {
        parent::__construct($fileModel);
        $this->activityRepository = $activityRepository;
    }

    public function activity()
    {
        $this->activityRepository->pushCriteria(NewMerchandiseActivityCriteria::class);
        $activity = $this->activityRepository->first();
        if($activity)
            return $this->response()->item($activity, new ActivityTransformer());
        else
            throw new ModelNotFoundException('没有相应的新品活动');
    }

    //
    public function storeActivity(NewActivityRequest $request)
    {
        $request->merge(['type' => Activity::NEW_PRODUCT_ACTIVITY, 'status' => Activity::HAVE_IN_HAND]);
        $activity = $this->activityRepository->create($request->all());
        return $this->response()->item($activity, new ActivityTransformer());
    }

    public function updateActivity(int $id, NewActivityRequest $request)
    {
        $request->merge(['type' => Activity::NEW_PRODUCT_ACTIVITY, 'status' => Activity::HAVE_IN_HAND]);
        $activity = $this->activityRepository->update($request->all(), $id);
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
        $this->activityRepository->pushCriteria(NewMerchandiseActivityCriteria::class);
        $activity = $this->activityRepository->find($activityId);
        if($activity) {
            $merchandise = with($activity, function (Activity $activity) use($request){
                return $activity->merchandises()->save(new ActivityMerchandise($request->all()));
            });
            return $this->response()->item($merchandise, new ActivityMerchandiseTransformer());
        }else{
            throw new ModelNotFoundException('找不到相应的活动');
        }

    }

    public function updateStock(int $activityId, int $id, NewActivityMerchandiseStockRequest $request)
    {
        $this->activityRepository->pushCriteria(NewMerchandiseActivityCriteria::class);
        $activity = $this->activityRepository->find($activityId);
        if($activity) {
            $merchandise = with($activity, function (Activity $activity) use($request, $id){
                return $activity->merchandises()->find($id);
            });

            if($merchandise) {
                $merchandise->stockNum = $request->input('stock_num');
                $merchandise->save();
                return $this->response()->item($merchandise, new ActivityMerchandiseTransformer());
            }else{
                throw new ModelNotFoundException('找不到相应的活动产品');
            }

        }else{
            throw new ModelNotFoundException('找不到相应的活动');
        }
    }

    public function merchandises(int $activityId, Request $request)
    {
        $this->activityRepository->pushCriteria(NewMerchandiseActivityCriteria::class);
        $activity = $this->activityRepository->find($activityId);
        if($activity) {
            $merchandises =with($activity, function (Activity $activity) use($request) {
                return $activity->merchandises()->paginate($request->input('limit', PAGE_LIMIT));
            });
            return $this->response()->paginator($merchandises, new ActivityMerchandiseTransformer());
        }else{
            throw new ModelNotFoundException('找不到相应的活动');
        }
    }
}
