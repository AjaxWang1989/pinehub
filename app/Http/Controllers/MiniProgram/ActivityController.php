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
    /**
     * @var ActivityRepository|null
     */
    protected  $activityRepository = null;

    /**
     * @var ActivityMerchandiseRepository|null
     */
    protected  $activityMerchandiseRepository = null;

    /**
     * @var ShopRepository|null
     */
    protected  $shopRepository = null;

    /**
     * ActivityController constructor.
     * @param ActivityRepository $activityRepository
     * @param ShopRepository $shopRepository
     * @param ActivityMerchandiseRepository $activityMerchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ActivityRepository $activityRepository,
                                ShopRepository $shopRepository,
                                ActivityMerchandiseRepository $activityMerchandiseRepository,
                                AppRepository $appRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->activityRepository            = $activityRepository;
        $this->activityMerchandiseRepository = $activityMerchandiseRepository;
        $this->shopRepository                = $shopRepository;
    }

    /**
     *获取新品预定的标题和背景图片
     * @return \Dingo\Api\Http\Response
     */
    public function newActivity()
    {
        $item = $this->activityRepository->newActivity();
        return $this->response()->item($item, new ActivityTransformer());
    }

    /**
     * 新品预定的商品信息
     * @param int $activityId
     * @return mixed
     */
    public function newActivityMerchandises(int $activityId)
    {
            $items = $this->activityMerchandiseRepository->newActivityMerchandises($activityId);
            return $this->response()->paginator($items,new ActivityMerchandiseTransformer());
    }
}
