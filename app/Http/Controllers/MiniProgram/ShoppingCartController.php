<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 11:06
 */

namespace App\Http\Controllers\MiniProgram;

use App\Http\Requests\MiniProgram\ShoppingCartCreateRequest;
use App\Services\AppManager;
use App\Entities\ShoppingCart;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\ActivityMerchandiseRepository;
use App\Transformers\Mp\ShoppingCartTransformer;
use App\Http\Response\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ShopMerchandiseRepository;

class ShoppingCartController extends Controller
{
    /**
     * @var MerchandiseRepository
     */
    protected $merchandiseRepository;

    /**
     * @var ShoppingCartRepository
     */
    protected $shoppingCartRepository;

    /**
     * @var ShopMerchandiseRepository
     */
    protected $shopMerchandiseRepository;

    /**
     * @var ActivityMerchandiseRepository
     */
    protected $activityMerchandiseRepository;

    /**
     * ShoppingCartController constructor.
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param ActivityMerchandiseRepository $activityMerchandiseRepository
     * @param ShopMerchandiseRepository $shopMerchandiseRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShoppingCartRepository $shoppingCartRepository,
                                ActivityMerchandiseRepository $activityMerchandiseRepository ,
                                ShopMerchandiseRepository $shopMerchandiseRepository,
                                MerchandiseRepository $merchandiseRepository,
                                AppRepository $appRepository,
                                Request $request)
    {
        parent::__construct($request, $appRepository);

        $this->appRepository                 = $appRepository;
        $this->merchandiseRepository         = $merchandiseRepository;
        $this->shoppingCartRepository        = $shoppingCartRepository;
        $this->shopMerchandiseRepository     = $shopMerchandiseRepository;
        $this->activityMerchandiseRepository = $activityMerchandiseRepository;
    }

    /**
     * 加入购物车
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function addMerchandise(ShoppingCartCreateRequest $request){
        $user = $this->mpUser();
        $shoppingCart = $request->all();

        //根据商品id查询商品的所有信息
        $merchandise = $this->merchandiseRepository->findWhere([
            'id'=>$shoppingCart['merchandise_id']
        ])->first();


        if (isset($shoppingCart['store_id']) && $shoppingCart['store_id']){
            //根据店铺id和商品id查询此店铺此商品的信息
            $Merchandise = $this->shopMerchandiseRepository->findWhere([
                'shop_id'=>$shoppingCart['store_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id']
            ])->first();

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'shop_id'=>$shoppingCart['store_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();

        }elseif (isset($shoppingCart['activity_id']) && $shoppingCart['activity_id']){
            //根据活动商品id查询此活动商品的库存
            $Merchandise = $this->activityMerchandiseRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id']
            ])->first();

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'activity_id'=>$shoppingCart['activity_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }else{
            $Merchandise = $merchandise;

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'shop_id' => null,
                'activity_id' => null,
                'customer_id' => $user['id']
            ])->first();
        }

        if ($Merchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '此商品没有库存了']));
        }

        $shoppingCart['shop_id'] = isset($shoppingCart['store_id']) ? $shoppingCart['store_id'] : null;
        $shoppingCart['activity_id'] = isset($shoppingCart['activity_id']) ? $shoppingCart['activity_id'] : null;
        $shoppingCart['name'] = $merchandise['name'];
        $shoppingCart['customer_id'] = $user->id;
        $shoppingCart['member_id'] = $user->memberId ? $user->memberId : null;
        $shoppingCart['sell_price'] = $merchandise['sell_price'];
        $shoppingCart['app_id'] = $user->appId;
        if ($shoppingMerchandise){
            $shoppingCart['quality'] = $shoppingMerchandise['quality']+1;
            $shoppingCart['amount'] = $merchandise['sell_price'] * $shoppingCart['quality'];
            $item = $this->shoppingCartRepository->update($shoppingCart,$shoppingMerchandise['id']);
            return $this->response()->item($item,new ShoppingCartTransformer);
        }else{
            $shoppingCart['amount'] = $merchandise['sell_price'] * $shoppingCart['quality'];
            $item = $this->shoppingCartRepository->create($shoppingCart);
            return $this->response()->item($item,new ShoppingCartTransformer);
        }
    }

    /**
     * 减少购物车商品
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function reduceMerchandise(ShoppingCartCreateRequest $request){
        $user = $this->mpUser();
        $shoppingCart = $request->all();

        if (isset($shoppingCart['store_id']) && $shoppingCart['store_id']){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'shop_id'=>$shoppingCart['store_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }elseif (isset($shoppingCart['activity_id']) && $shoppingCart['activity_id']){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'activity_id'=>$shoppingCart['activity_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }else{
            $shoppingMerchandise = $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'shop_id' => null,
                'activity_id' => null,
                'customer_id'=>$user['id']
            ])->first();
        }

        if ($shoppingMerchandise['quality'] != 1){
            $shoppingCart['quality'] = $shoppingMerchandise['quality']-1;
            $shoppingCart['amount'] = $shoppingMerchandise['sell_price'] * $shoppingCart['quality'];
            $item = $this->shoppingCartRepository->update($shoppingCart,$shoppingMerchandise['id']);
            return $this->response()->item($item,new ShoppingCartTransformer);
        }else{
            $item= $this->shoppingCartRepository->delete($shoppingMerchandise['id']);
            return $this->response(new JsonResponse(['delete_count' => $item]));
        }
    }

    /**
     * 清空购物车
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */
    public function emptyMerchandise(int $storeId = null, int $activityId = null){
        $user = $this->mpUser();
        if (isset($storeId) && $storeId){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$storeId,'customer_id'=>$user['id']]);
        }elseif(isset($activityId) && $activityId){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['activity_id'=>$activityId,'customer_id'=>$user['id']]);
        }else{
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'customer_id'=>$user['id'],
                'shop_id' => null,
                'activity_id' => null,
            ]);
        }
        $deleteIds = [];
        foreach ($shoppingMerchandise as $v){
            $deleteIds[] = $v['id'];
        }
        $item = ShoppingCart::destroy($deleteIds);
        return $this->response(new JsonResponse(['delete_count' => $item]));
    }

    /**
     * 获取购物车商品信息
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */

    public function shoppingCartMerchandises(int $storeId = null,int $activityId = null){
        $user = $this->mpUser();
        $userId =$user['id'];
        $items  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId ,$activityId ,$userId);
        return $this->response()->paginator($items,new ShoppingCartTransformer);
    }

}