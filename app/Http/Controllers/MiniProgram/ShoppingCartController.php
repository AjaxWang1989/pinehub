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

class ShoppingCartController extends Controller
{
    protected $merchandiseRepository;
    protected $shoppingCartRepository;

    /**
     * ShoppingCartController constructor.
     * @param ShoppingCartRepository $shoppingCartRepository
     * @param MerchandiseRepository $merchandiseRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(ShoppingCartRepository $shoppingCartRepository,MerchandiseRepository $merchandiseRepository,AppRepository $appRepository,Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->appRepository = $appRepository;
        $this->merchandiseRepository = $merchandiseRepository;
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    /**
     * 加入购物车
     * @param CreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function addMerchandise(CreateRequest $request){
        $user = $this->user();
        $user['id'] = $user ? $user['id'] : '1';
        $shoppingCart = $request->all();
        $merchandise = $this->merchandiseRepository->findWhere(['id'=>$shoppingCart['merchandise_id']])->first();
        $shoppingMerchandise = $this->shoppingCartRepository->findWhere(['shop_id'=>$shoppingCart['shop_id'],'merchandise_id'=>$shoppingCart['merchandise_id'],'user_id'=>$user['id']])->first();
        $shoppingCart['name'] = $merchandise['name'];
        $shoppingCart['user_id'] = $user['id'];
        $shoppingCart['sell_price'] = $merchandise['sell_price'];
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
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */

    public function shoppingCartMerchandises(int $storeId){
        $user = $this->user();
        $userId = $user ? $user['id'] : '1';
        $shoppingCartMerchandises  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId,$userId);
        return $this->response()->paginator($shoppingCartMerchandises,new ShoppingCartTransformer);
    }

}