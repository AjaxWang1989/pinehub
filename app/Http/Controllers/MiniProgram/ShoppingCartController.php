<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 11:06
 */

namespace App\Http\Controllers\MiniProgram;

use App\Http\Requests\CreateRequest;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShoppingCartRepository;
use App\Transformers\Mp\ShoppingCartTransformer;
use App\Http\Response\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ShopMerchandiseRepository;

class ShoppingCartController extends Controller
{
    protected $merchandiseRepository;
    protected $shoppingCartRepository;
    protected $shopMerchandiseRepository;

    /**
     * ShoppingCartController constructor.
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShoppingCartRepository $shoppingCartRepository,ShopMerchandiseRepository $shopMerchandiseRepository,MerchandiseRepository $merchandiseRepository,AppRepository $appRepository,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->shopMerchandiseRepository = $shopMerchandiseRepository;
    }

    /**
     * 加入购物车
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function addMerchandise(CreateRequest $request){
        $accessToken = $request->input('access_token', null);
        $appId = Cache::get($accessToken);
        $user = $this->user();
        $shoppingCart = $request->all();
        $shopMerchandise = $this->shopMerchandiseRepository->findWhere(['shop_id'=>$shoppingCart['store_id'],'merchandise_id'=>$shoppingCart['merchandise_id']])->first();
        if ($shopMerchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '此商品没有库存了']));
        }
        $merchandise = $this->merchandiseRepository->findWhere(['id'=>$shoppingCart['merchandise_id']])->first();
        $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$shoppingCart['store_id'],'merchandise_id'=>$shoppingCart['merchandise_id'],'customer_id'=>$user['id']])->first();
        $shoppingCart['shop_id'] = $shoppingCart['store_id'];
        $shoppingCart['name'] = $merchandise['name'];
        $shoppingCart['customer_id'] = $user['id'];
        $shoppingCart['member_id'] = $user['member_id'];
        $shoppingCart['sell_price'] = $merchandise['sell_price'];
        $shoppingCart['app_id'] = $appId;
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
    public function reduceMerchandise(Request $request){
        $user = $this->user();
        $shoppingCart = $request->all();
        $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$shoppingCart['store_id'],'merchandise_id'=>$shoppingCart['merchandise_id'],'customer_id'=>$user['id']])->first();
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
    public function emptyMerchandise(int $storeId){
        $user = $this->user();
        $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$storeId,'customer_id'=>$user['id']]);
        foreach ($shoppingMerchandise as $v){
            $item = $this->shoppingCartRepository->delete($v['id']);
        }
        return $this->response(new JsonResponse(['delete_count' => $item]));
    }

    /**
     * 获取购物车商品信息
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */

    public function shoppingCartMerchandises(int $storeId){
        $user = $this->user();
        $userId =$user['id'];
        $items  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId,$userId);
        return $this->response()->paginator($items,new ShoppingCartTransformer);
    }

}