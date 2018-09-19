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
use App\Repositories\ActivityMerchandiseRepository;
use App\Transformers\ActivityTransformer;
use App\Transformers\Mp\ActivityMerchandiseTransformer;
use Dingo\Api\Http\Request;

class ActivityController extends Controller
{
    protected  $activityRepository = null;
    protected  $activityMerchandiseRepository = null;

    public function __construct(ActivityRepository $activityRepository,ActivityMerchandiseRepository $activityMerchandiseRepository, AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->activityRepository = $activityRepository;
        $this->activityMerchandiseRepository = $activityMerchandiseRepository;
    }

    /**
     *获取新品预定的标题和背景图片
     * @return \Dingo\Api\Http\Response
     */
    public function newActivity(){
        $user = $this->user();
        $userId = $user ? $user['id'] : '1';
        $item = $this->activityRepository->findWhere(['shop_id'=>$userId])->first();
        return $this->response()->item($item, new ActivityTransformer());
    }

    /**
     * 新品预定的商品信息
     * @param int $activityId
     * @return mixed
     */
    public function newActivityMerchandise(int $activityId){
        $user = $this->user();
        $userId = $user ? $user['id'] : '1';
        $item = $this->activityMerchandiseRepository->newActivityMerchandise($activityId,$userId);
        return $this->response()->paginator($item,new ActivityMerchandiseTransformer());
    }
}
