<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 11:06
 */

namespace App\Http\Controllers\MiniProgram;

use App\Http\Requests\MiniProgram\BookingMallShoppingCartRequest;
use App\Http\Requests\MiniProgram\StoreShoppingCartRequest;
use App\Http\Requests\MiniProgram\ActivityShoppingCartRequest;
use App\Services\AppManager;
use App\Entities\ShoppingCart;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\ActivityMerchandiseRepository;
use App\Transformers\Mp\ShoppingCartTransformer;
use App\Http\Response\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message)
    {
        if($shoppingCart) {
            $shoppingCart->quality = $quality;
            $shoppingCart->amount = $shoppingCart->sellPrice * $quality;
            $shoppingCart->save();
            return $this->response()->item($shoppingCart, new ShoppingCartTransformer());
        }else{
            throw new ModelNotFoundException($message.'购物车没有相应商品无法修改数量。');
        }
    }
    /**
     * 增加和修改活动商品购物车
     * @param int $activityId
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function activityShoppingCartMerchandiseNumChange(int $activityId, ActivityShoppingCartRequest $request)
    {
        $shoppingCart = $this->shoppingCartRepository->findWhere([
            'activity_id'    => $activityId,
            'merchandise_id' => $request->input('merchandise_id')
        ])->first();

        $quality = $request->input('quality');
        $message = '活动';

        return $this->shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message);
    }

    /**
     * 赠加和修改店铺购物车
     * @param int $storeId
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeShoppingCartMerchandiseNumChange(int $storeId, StoreShoppingCartRequest $request)
    {
        $shoppingCart = $this->shoppingCartRepository->findWhere([
            'shop_id'=>$storeId,
            'merchandise_id'=>$request->input('merchandise_id'),
        ])->first();

        $quality = $request->input('quality');
        $message = '店铺';

        return $this->shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message);
    }

    /**
     * 增加和修改预定商城购物车
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartMerchandiseNumChange(BookingMallShoppingCartRequest $request)
    {
        $shoppingCart = $this->shoppingCartRepository->findWhere([
            'activity_id' => null,
            'shop_id'     => null,
            'merchandise_id'=>$request->input('merchandise_id'),
        ])->first();

        $quality = $request->input('quality');
        $message = '预定商城';

        return $this->shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message);
    }

    public function shoppingCartAddMerchandise($shoppingCart,$merchandise)
    {
        $user = $this->mpUser();
        $shoppingCart['customer_id'] = $user->id;
        $shoppingCart['member_id'] = $user->memberId ? $user->memberId : null;
        $shoppingCart['sell_price'] = $merchandise['sell_price'];
        $shoppingCart['app_id'] = $user->appId;
        $shoppingCart['amount'] = $shoppingCart['sell_price'] * $shoppingCart['quality'];

        $item = $this->shoppingCartRepository->create($shoppingCart);
        return $this->response()->item($item, new ShoppingCartTransformer);
    }
    /**
     * 新增一条活动商品购物车
     * @param int $activityId
     * @param Request $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function activityShoppingCartAddMerchandise(int $activityId, ActivityShoppingCartRequest $request)
    {
        $merchandise = $this->activityMerchandiseRepository->findWhere([
            'activity_id' => $activityId,
            'merchandise_id'=>$request->input('merchandise_id')
        ])->first();

        if ($merchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '活动此商品没有库存了']));
        }

        $shoppingCart['activity_id'] = $activityId;
        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');

        return $this->shoppingCartAddMerchandise($shoppingCart,$merchandise);
    }

    /**
     * 新增一条店铺购物车
     * @param int $storeId
     * @param Request $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function storeShoppingCartAddMerchandise(int $storeId, StoreShoppingCartRequest $request)
    {
        $merchandise = $this->shopMerchandiseRepository->findWhere([
            'shop_id' => $storeId,
            'merchandise_id'=>$request->input('merchandise_id')
        ])->first();

        if ($merchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '店铺此商品没有库存了']));
        }

        $shoppingCart['shop_id'] = $storeId;
        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');

        return $this->shoppingCartAddMerchandise($shoppingCart,$merchandise);
    }

    /**
     * 新增一条预定商城购物车
     * @param Request $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartAddMerchandise(BookingMallShoppingCartRequest $request)
    {
        $merchandise = $this->merchandiseRepository->findWhere([
            'id'=>$request->input('merchandise_id')
        ])->first();

        if ($merchandise['stock_num'] <=0){
            return $this->response(new JsonResponse(['message' => '预定此商品没有库存了']));
        }

        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');
        return $this->shoppingCartAddMerchandise($shoppingCart,$merchandise);
    }

    /**
     * 删除一条购物车数据
     * @param int $id
     */
    public function shoppingCartDelete(int $id) {
        $result = $this->shoppingCartRepository->delete($id);
        return $this->response(new JsonResponse(['delete_count' => $result]));
    }

    /**
     * 清空购物车
     * @param int $storeId
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */
    public function clearShoppingCart(int $storeId = null, int $activityId = null){
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
     * 清空店铺购物车
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */
    public function clearStoreShoppingCart(int $storeId = null){
        return $this->clearShoppingCart($storeId);
    }

    /**
     * 清空活动购物车
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */
    public function clearActivityShoppingCart(int $activityId = null){
        return $this->clearShoppingCart(null, $activityId);
    }

    /**
     * 清空预定商城购物车
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */
    public function clearBookingMallShoppingCart(){
        return $this->clearShoppingCart();
    }

    /**
     * 店铺购物车
     * @param int $storeId
     * @return \Dingo\Api\Http\Response
     */
    public function storeShoppingCartMerchandises(int $storeId = null){
        return $this->shoppingCartMerchandises($storeId);
    }

    /**
     * 活动购物车
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */
    public function activityShoppingCartMerchandises(int $activityId = null){
        return $this->shoppingCartMerchandises(null, $activityId);
    }



    /**
     * 预定商城购物车
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartMerchandises(){
        return $this->shoppingCartMerchandises();
    }


    /**
     * 获取购物车商品信息
     * @param int $storeId
     * @param int|null $activityId
     * @return \Dingo\Api\Http\Response
     */

    public function shoppingCartMerchandises(int $storeId = null,int $activityId = null){
        $user = $this->mpUser();
        $userId =$user['id'];
        $items  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId ,$activityId ,$userId);
        return $this->response()->paginator($items, new ShoppingCartTransformer);
    }

}