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
    protected $merchandiseRepository;
    protected $shoppingCartRepository;
    protected $shopMerchandiseRepository;
    protected $activityMerchandiseRepository;

    /**
     * ShoppingCartController constructor.
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShoppingCartRepository $shoppingCartRepository,ActivityMerchandiseRepository $activityMerchandiseRepository ,ShopMerchandiseRepository $shopMerchandiseRepository,MerchandiseRepository $merchandiseRepository,AppRepository $appRepository,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->shopMerchandiseRepository = $shopMerchandiseRepository;
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

        $merchandise = $this->merchandiseRepository->findWhere(['id'=>$shoppingCart['merchandise_id']])->first();

        if (isset($shoppingCart['store_id']) && $shoppingCart['store_id']){
            $Merchandise = $this->shopMerchandiseRepository->findWhere([
                'shop_id'=>$shoppingCart['store_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id']
            ])->first();

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'shop_id'=>$shoppingCart['store_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }elseif (isset($shoppingCart['activity_merchandises_id']) && $shoppingCart['activity_merchandises_id']){
            $Merchandise = $this->activityMerchandiseRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id']
            ])->first();

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'activity_merchandises_id'=>$shoppingCart['activity_merchandises_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }else{
            $Merchandise = $merchandise;

            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'shop_id' => null,
                'activity_merchandises_id' => null,
                'customer_id' => $user['id']
            ])->first();
        }

        if ($Merchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '此商品没有库存了']));
        }

        $shoppingCart['shop_id'] = $shoppingCart['store_id'] ? $shoppingCart['store_id'] : null;
        $shoppingCart['activity_merchandises_id'] = $shoppingCart['activity_merchandises_id'] ? $shoppingCart['activity_merchandises_id'] : null;
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
        }elseif (isset($shoppingCart['activity_merchandises_id']) && $shoppingCart['activity_merchandises_id']){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'activity_merchandises_id'=>$shoppingCart['activity_merchandises_id'],
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'customer_id'=>$user['id']
            ])->first();
        }else{
            $shoppingMerchandise = $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'merchandise_id'=>$shoppingCart['merchandise_id'],
                'shop_id' => null,
                'activity_merchandises_id' => null,
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
    public function emptyMerchandise(int $storeId = null, int $activityMerchandiseId = null){
        $user = $this->mpUser();
        $item = '';
        if (isset($storeId) && $storeId){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$storeId,'customer_id'=>$user['id']]);
        }elseif(isset($activityMerchandiseId) && $activityMerchandiseId){
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['activity_merchandises_id'=>$activityMerchandiseId,'customer_id'=>$user['id']]);
        }else{
            $shoppingMerchandise = $this->shoppingCartRepository->findWhere([
                'customer_id'=>$user['id'],
                'shop_id' => null,
                'activity_merchandises_id' => null,
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

    public function shoppingCartMerchandises(int $storeId = null,int $activityMerchandiseId = null){
        $user = $this->mpUser();
        $userId =$user['id'];
        $items  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId ,$activityMerchandiseId ,$userId);
        return $this->response()->paginator($items,new ShoppingCartTransformer);
    }

}