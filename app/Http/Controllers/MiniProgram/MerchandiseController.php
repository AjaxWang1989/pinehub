<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/11/24
 * Time: 上午9:46
 */

namespace App\Http\Controllers\MiniProgram;


use App\Entities\Activity;
use App\Entities\Category;
use App\Entities\Merchandise;
use App\Entities\Shop;
use App\Repositories\ActivityRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ShopRepository;
use App\Services\AppManager;
use App\Transformers\Mp\ActivityMerchandiseTransformer;
use App\Transformers\Mp\BookingMallMerchandiseItemTransformer;
use App\Transformers\Mp\StoreMerchandiseTransformer;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;

class MerchandiseController extends Controller
{
    /**
     * 预定商城产品列表
     * @param int $categoryId
     * @param CategoryRepository $repository
     * @return Response
     * @throws
     * */
    public function bookingMallMerchandises (int $categoryId, CategoryRepository $repository)
    {
        $category = $repository->find($categoryId);
        if ($category) {
            return with($category, function (Category $category) {
                $request = Request::instance();
                $merchandises = $category->merchandises()
                    ->where('app_id', app(AppManager::class)->getAppId())
                    ->where('status', Merchandise::UP)
                    ->paginate($request->input('limit', PAGE_LIMIT));
                return $this->response()->paginator($merchandises, new BookingMallMerchandiseItemTransformer());
            });
        } else {
            throw new ModelNotFoundException('没有找到相应的分类');
        }
    }

    /**
     * 邻里优先产品列表
     * @param ShopRepository $repository
     * @param int $shopId
     * @param int $categoryId
     * @return Response
     * @throws
     * */
    public function nearbyShopMerchandises (ShopRepository $repository, int $shopId, int $categoryId = null)
    {
        $shop = $repository->find($shopId);
        if ($shop) {
            return with($shop, function (Shop $shop) use($categoryId){
                $request = Request::instance();
                $merchandises = $shop->shopMerchandises()->with(['merchandise'])
                    ->whereHas('merchandise', function (Builder $query) {
                        return $query->where('merchandises.status', Merchandise::UP);
                    })
                    ->whereHas('merchandise.categories', function (Builder $query) use($categoryId){
                        if ($categoryId) {
                            return $query->where('id', $categoryId);
                        } else {
                            return $query;
                        }
                    })
                    ->paginate($request->input('limit'), PAGE_LIMIT);
                return $this->response()->paginator($merchandises, new StoreMerchandiseTransformer());
            });
        } else {
            throw new ModelNotFoundException('没有找到相应的店铺');
        }
    }

    /**
     * 新品活动产品列表
     * @param ActivityRepository $repository
     * @param int $activityId
     * @param int $categoryId
     * @return Response
     * @throws
     * */
    public function newEventsMerchandises (ActivityRepository $repository, int $activityId, int $categoryId = null)
    {
        $activity = $repository->find($activityId);
        if ($activity) {
            return with($activity, function (Activity $activity) use($categoryId){
                $request = Request::instance();
                $merchandises = $activity->merchandises()
                    ->with(['merchandise'])
                    ->whereHas('merchandise', function ($query) {
                        return $query->where('status', Merchandise::UP);
                    })
                    ->whereHas('merchandise.categories', function ($query) use($categoryId){
                        if ($categoryId) {
                            return $query->where('id', $categoryId);
                        } else {
                            return $query;
                        }})
                    ->paginate($request->input('limit'), PAGE_LIMIT);
                return $this->response()->paginator($merchandises, new ActivityMerchandiseTransformer());
            });
        } else {
            throw new ModelNotFoundException('没有找到相应的活动');
        }
    }
}