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
use App\Repositories\ShopRepository;
use App\Repositories\ActivityMerchandiseRepository;
use App\Transformers\ActivityTransformer;
use App\Transformers\Mp\ActivityMerchandiseTransformer;
use Dingo\Api\Http\Request;
use App\Http\Response\JsonResponse;

class ActivityController extends Controller
{
    protected  $activityRepository = null;
    protected  $activityMerchandiseRepository = null;
    protected  $shopRepository = null;

    /**
     * ActivityController constructor.
     * @param ActivityRepository $activityRepository
     * @param ShopRepository $shopRepository
     * @param ActivityMerchandiseRepository $activityMerchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ActivityRepository $activityRepository,ShopRepository $shopRepository,ActivityMerchandiseRepository $activityMerchandiseRepository, AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->activityRepository = $activityRepository;
        $this->activityMerchandiseRepository = $activityMerchandiseRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     *获取新品预定的标题和背景图片
     * @return \Dingo\Api\Http\Response
     */
    public function newActivity()
    {
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $item = $this->activityRepository->findWhere(['shop_id'=>$userId])->first();
            return $this->response()->item($item, new ActivityTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }

    /**
     * 新品预定的商品信息
     * @param int $activityId
     * @return mixed
     */
    public function newActivityMerchandise(int $activityId)
    {
        $user = $this->user();
        $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
        if ($shopUser){
            $userId = $shopUser['id'];
            $item = $this->activityMerchandiseRepository->newActivityMerchandise($activityId,$userId);
            return $this->response()->paginator($item,new ActivityMerchandiseTransformer());
        }
        return $this->response(new JsonResponse(['shop_id' => $shopUser]));
    }
}
