<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 18:40
 */

namespace App\Http\Controllers\MiniProgram;


use App\Entities\Activity;
use App\Repositories\ActivityRepository;
use App\Repositories\AppRepository;
use App\Transformers\ActivityTransformer;
use Dingo\Api\Http\Request;

class ActivityController extends Controller
{
    protected  $activityRepository = null;

    public function __construct(ActivityRepository $activityRepository, AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->activityRepository = $activityRepository;
    }

    public function newActivity(string $id='1'){
        $item = $this->activityRepository->find($id);
        return $this->response()->item($item, new ActivityTransformer());
    }
}
