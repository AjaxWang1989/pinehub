<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 11:06
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\ActivityMerchandise;
use App\Entities\Merchandise;
use App\Entities\Shop;
use App\Entities\ShopMerchandise;
use App\Entities\StoreShoppingCart;
use App\Exceptions\HttpValidationException;
use App\Http\Requests\MiniProgram\BookingMallShoppingCartRequest;
use App\Http\Requests\MiniProgram\MerchantShoppingCartAddRequest;
use App\Http\Requests\MiniProgram\StoreShoppingCartRequest;
use App\Http\Requests\MiniProgram\ActivityShoppingCartRequest;

use App\Http\Requests\MiniProgram\ActivityShoppingCartAddRequest;
use App\Http\Requests\MiniProgram\StoreShoppingCartAddRequest;
use App\Http\Requests\MiniProgram\BookingMallShoppingCartAddRequest;
use App\Repositories\OrderRepository;
use App\Services\AppManager;
use App\Entities\ShoppingCart;
use App\Transformers\Mp\StoreShoppingCartTransformer;
use App\Transformers\Mp\UsuallyStoreAddressTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use App\Repositories\AppRepository;
use App\Repositories\MerchandiseRepository;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\ActivityMerchandiseRepository;
use App\Transformers\Mp\ShoppingCartTransformer;
use App\Http\Response\JsonResponse;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ShopMerchandiseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function shoppingCartMerchandiseNumChange(ShoppingCart $shoppingCart, int $quality, string $message)
    {
        if($shoppingCart) {
            $shoppingCart->quality = $quality;
            $shoppingCart->amount = round($shoppingCart->sellPrice,2) * $quality;
            $shoppingCart->save();
            return $this->response()->item($shoppingCart, new ShoppingCartTransformer());
        }else{
            throw new ModelNotFoundException($message.'购物车没有相应商品无法修改数量。');
        }
    }
    /**
     * 增加和修改活动商品购物车
     * @param int $activityId
     * @param int $shoppingCartId
     * @param ActivityShoppingCartRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function activityShoppingCartMerchandiseNumChange(int $activityId, int $shoppingCartId, ActivityShoppingCartRequest $request)
    {
        /** @var ActivityMerchandise $activityMerchandise */
        $activityMerchandise = $this->activityMerchandiseRepository
            ->with(['merchandise'])
            ->scopeQuery(function ($merchandise) use($activityId, $request){
                return $merchandise->where('activity_id', $activityId)
                    ->where('merchandise_id', $request->input('merchandise_id'));
            })->first();
        if(!$activityMerchandise || !$activityMerchandise->merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }
        Log::info('activity merchandise', [$activityMerchandise['stock_num'], $request->input('quality')]);
        if ($activityMerchandise['stock_num'] < $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }

        /** @var ShoppingCart $shoppingCart */
        $shoppingCart = $this->shoppingCartRepository->scopeQuery(function (ShoppingCart $shoppingCart) use($activityId,$request){
            return $shoppingCart->where('activity_id', $activityId)
                ->where('merchandise_id',$request->input('merchandise_id'))
                ->where('type', ShoppingCart::USER_ORDER);
        })->find($shoppingCartId);

        $quality = $request->input('quality');
        $message = '活动';
        return DB::transaction(function () use ($activityMerchandise, $quality, $shoppingCart, $message){
//            $num = $quality - $shoppingCart->quality;
//            $activityMerchandise->stockNum -= $num;
//            $activityMerchandise->sellNum += $num;
//            $activityMerchandise->save();
            return $this->shoppingCartMerchandiseNumChange($shoppingCart, $quality, $message);
        });

    }

    /**
     * 赠加和修改店铺购物车
     * @param int $storeId
     * @param int $shoppingCartId
     * @param StoreShoppingCartRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function storeShoppingCartMerchandiseNumChange(int $storeId, int $shoppingCartId, StoreShoppingCartRequest $request)
    {
        /** @var ShopMerchandise $shopMerchandise */
        $shopMerchandise = $this->shopMerchandiseRepository
            ->with(['merchandise'])
            ->scopeQuery(function ($merchandise) use($storeId, $request){
                return $merchandise->where('shop_id', $storeId)
                    ->where('merchandise_id', $request->input('merchandise_id'));
            })->first();
        if(!$shopMerchandise || !$shopMerchandise->merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }

        Log::info('shop merchandise', [$shopMerchandise['stock_num'], $request->input('quality')]);
        if ($shopMerchandise['stock_num'] <= $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }
        /** @var ShoppingCart $shoppingCart */
        $shoppingCart = $this->shoppingCartRepository->scopeQuery(function (ShoppingCart $shoppingCart) use($storeId,$request){
            return $shoppingCart->where('shop_id', $storeId)
            ->where('merchandise_id',$request->input('merchandise_id'))
            ->where('type', ShoppingCart::USER_ORDER);
        })->find($shoppingCartId);

        $quality = $request->input('quality');
        $message = '店铺';

        return DB::transaction(function () use($shopMerchandise, $shoppingCart, $quality, $message) {
//            $num = $quality - $shoppingCart->quality;
//            $shopMerchandise->stockNum -= $num;
//            $shopMerchandise->sellNum += $num;
//            $shopMerchandise->save();
            return $this->shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message);
        });


    }

    /**
     * 赠加和修改店铺购物车
     * @param int $storeId
     * @param int $shoppingCartId
     * @param StoreShoppingCartRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function merchantShoppingCartMerchandiseNumChange(int $storeId, int $shoppingCartId, StoreShoppingCartRequest $request)
    {
        /** @var ShopMerchandise $shopMerchandise */
        $shopMerchandise = $this->merchandiseRepository
            ->scopeQuery(function ($merchandise) use($request){
                return $merchandise->where('id', $request->input('merchandise_id'));
            })->first();
        if(!$shopMerchandise) {
            throw new ModelNotFoundException('产品不存在');
        }

        Log::info('shop merchandise', [$shopMerchandise['stock_num'], $request->input('quality')]);
        if ($shopMerchandise['stock_num'] <= $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }
        /** @var ShoppingCart $shoppingCart */
        $shoppingCart = $this->shoppingCartRepository->scopeQuery(function (ShoppingCart $shoppingCart) use($storeId,$request){
            return $shoppingCart->where('shop_id', $storeId)
                ->where('type', ShoppingCart::MERCHANT_ORDER)
                ->where('merchandise_id',$request->input('merchandise_id'));
        })->find($shoppingCartId);

        $quality = $request->input('quality');
        $message = '店铺';
        return DB::transaction(function () use($shopMerchandise, $shoppingCart, $quality, $message) {
//            $num = $quality - $shoppingCart->quality;
//            $shopMerchandise->stockNum -= $num;
//            $shopMerchandise->sellNum += $num;
//            $shopMerchandise->save();
            return $this->shoppingCartMerchandiseNumChange($shoppingCart, $quality, $message);
        });
    }

    /**
     * 增加和修改预定商城购物车
     * @param int $shoppingCartId
     * @param BookingMallShoppingCartRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartMerchandiseNumChange(int $shoppingCartId, BookingMallShoppingCartRequest $request)
    {
        /** @var Merchandise $merchandise */
        $merchandise = $this->merchandiseRepository
            ->scopeQuery(function (Merchandise $merchandise) use ($request){
                return $merchandise->where('id', $request->input('merchandise_id'));
            })
            ->first();
        if (!$merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }

        Log::info('shop merchandise', [$merchandise['stock_num'], $request->input('quality')]);
        if ($merchandise['stock_num'] < $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }

        /** @var ShoppingCart $shoppingCart */
        $shoppingCart = $this->shoppingCartRepository->scopeQuery(function (ShoppingCart $shoppingCart) use($request){
            return $shoppingCart->where('merchandise_id', $request->input('merchandise_id'))
                    ->where('type', ShoppingCart::USER_ORDER);
        })->find($shoppingCartId);

        $quality = $request->input('quality');
        $message = '预定商城';

        return DB::transaction(function () use($merchandise, $shoppingCart, $quality, $message) {
//            $num = $quality - $shoppingCart->quality;
//            $merchandise->stockNum -= $num;
//            $merchandise->sellNum += $num;
//            $merchandise->save();
            return $this->shoppingCartMerchandiseNumChange($shoppingCart,$quality,$message);
        });

    }

    public function shoppingCartAddMerchandise($shoppingCart, $merchandise)
    {
        $user = $this->mpUser();
        $shoppingCart['customer_id'] = $user->id;
        $shoppingCart['member_id'] = $user->memberId ? $user->memberId : null;
        $shoppingCart['sell_price'] = round($merchandise['sell_price'],2);
        $shoppingCart['app_id'] = $user->appId;
        $shoppingCart['amount'] = round($merchandise['sell_price'],2) * $shoppingCart['quality'];
        $item = $this->shoppingCartRepository->create($shoppingCart);
        return $this->response()->item($item, new ShoppingCartTransformer);
    }
    /**
     * 新增一条活动商品购物车
     * @param int $activityId
     * @param ActivityShoppingCartAddRequest $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function activityShoppingCartAddMerchandise(int $activityId, ActivityShoppingCartAddRequest $request)
    {
        $activityMerchandise = $this->activityMerchandiseRepository
            ->with(['merchandise'])
            ->scopeQuery(function ( $merchandise) use($activityId, $request){
            return $merchandise->where('activity_id', $activityId)
                ->where('merchandise_id', $request->input('merchandise_id'));
        })->first();
        if(!$activityMerchandise || !$activityMerchandise->merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }
        $merchandise = $activityMerchandise->merchandise;

        if ($activityMerchandise['stock_num'] < $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }

        $shoppingCart['activity_id'] = $activityId;
        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');
        $shoppingCart['type'] = ShoppingCart::USER_ORDER;
        return DB::transaction(function () use ($activityMerchandise, $shoppingCart, $merchandise){
//            $activityMerchandise->stockNum -= 1;
//            $activityMerchandise->sellNum += 1;
//            $activityMerchandise->save();
            return $this->shoppingCartAddMerchandise($shoppingCart, $merchandise);
        });

    }

    /**
     * 新增一条店铺购物车
     * @param int $storeId
     * @param StoreShoppingCartAddRequest $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function storeShoppingCartAddMerchandise(int $storeId, StoreShoppingCartAddRequest $request)
    {
        $shopMerchandise = $this->shopMerchandiseRepository
            ->with(['merchandise'])
            ->scopeQuery(function ($merchandise) use($storeId, $request){
                return $merchandise->where('shop_id', $storeId)
                    ->where('merchandise_id', $request->input('merchandise_id'));
            })->first();
        if(!$shopMerchandise || !$shopMerchandise->merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }
        $merchandise = $shopMerchandise->merchandise;

        Log::info('shop merchandise', [$shopMerchandise['stock_num'], $request->input('quality')]);
        if ($shopMerchandise['stock_num'] <= $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }

        $shoppingCart['shop_id'] = $storeId;
        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');
        $shoppingCart['type'] = ShoppingCart::USER_ORDER;
        return DB::transaction(function () use ($shopMerchandise, $shoppingCart, $merchandise){
//            $shopMerchandise->stockNum -= 1;
//            $shopMerchandise->sellNum += 1;
//            $shopMerchandise->save();
            return $this->shoppingCartAddMerchandise($shoppingCart, $merchandise);
        });
    }

    /**
     * 新增一条预定商城购物车
     * @param BookingMallShoppingCartAddRequest $request
     * @return $this|\Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartAddMerchandise(BookingMallShoppingCartAddRequest $request)
    {
        $merchandise = $this->merchandiseRepository->findWhere([
            'id'=>$request->input('merchandise_id')
        ])->first();

        if(!$merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }

        if ($merchandise['stock_num'] <= $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }

        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');
        $shoppingCart['type'] = ShoppingCart::USER_ORDER;

        return DB::transaction(function () use ($shoppingCart, $merchandise){
//            $merchandise->stockNum -= 1;
//            $merchandise->sellNum += 1;
//            $merchandise->save();
            return $this->shoppingCartAddMerchandise($shoppingCart, $merchandise);
        });
    }

    /**
     * 删除一条购物车数据
     * @param int $id
     * @return Response
     */
    public function shoppingCartDelete(int $id) {
        /** @var ShoppingCart $shoppingCart */
        $shoppingCart = $this->shoppingCartRepository->with(['activity'])->find($id);
        if($shoppingCart) {
            return DB::transaction(function () use ($shoppingCart) {
                /** @var ShopMerchandise|ActivityMerchandise|Merchandise $merchandise */
//                $merchandise = $shoppingCart->activity ? $shoppingCart->activity->merchandises()
//                    ->where(['merchandise_id' => $shoppingCart->merchandiseId])->first() : null;
//                if($merchandise) {
//                    $merchandise->stockNum += 1;
//                    $merchandise->sellNum -= 1;
//                    $merchandise->save();
//                }else{
//                    $merchandise = $shoppingCart->shop ? $shoppingCart->shop->shopMerchandises()
//                        ->where(['merchandise_id' => $shoppingCart->merchandiseId])->first() : null;
//                    if($merchandise) {
//                        $merchandise->stockNum += 1;
//                        $merchandise->sellNum -= 1;
//                        $merchandise->save();
//                    }else{
//                        $merchandise = $shoppingCart->merchandise;
//                        if($merchandise) {
//                            $merchandise->stockNum += 1;
//                            $merchandise->sellNum -= 1;
//                            $merchandise->save();
//                        }
//                    }
//                }
                $result  = $shoppingCart->delete();
                return $this->response(new JsonResponse(['delete_count' => $result]));
            });
        }else{
            throw new ModelNotFoundException(['message' => '没有购物车数据']);
        }

    }

    /**
     * 清空购物车
     * @param int $storeId
     * @param int|null $activityId
     * @param string $type
     * @return \Dingo\Api\Http\Response
     */
    public function clearShoppingCart(int $storeId = null, int $activityId = null, string $type = ShoppingCart::USER_ORDER){
        return DB::transaction(function () use($storeId, $activityId, $type){
            $user = $this->mpUser();
            $deleteIds = [];
            if (isset($storeId) && $storeId){
                /** @var ShoppingCart[]|Collection $shoppingCarts */
                $shoppingCarts = $this->shoppingCartRepository->with(['shopMerchandise'])->findWhere([
                    'shop_id' => $storeId,
                    'customer_id' => $user['id'],
                    'type' => $type
                ]);
                $whereFields = [];
                foreach ($shoppingCarts as $v){
                    $deleteIds[] = $v->id;
                    $whereFields[] = [
                        'shop_id' => $v->shopId,
                        'merchandise_id' => $v->merchandiseId
                    ];
                }
                /** @var Collection $merchandises */
//                $merchandises = $this->shopMerchandiseRepository->findWhere($whereFields);
//                if($merchandises && $merchandises->count() > 0) {
//                    $merchandises->map(function (ShopMerchandise $merchandise) use ($shoppingCarts) {
//                        /** @var ShoppingCart $shoppingCart */
//                        $shoppingCart = $shoppingCarts->where([
//                            'shop_id' => $merchandise->shopId,
//                            'merchandise_id' => $merchandise->merchandiseId
//                        ])->first();
//                        $merchandise->sellNum -= $shoppingCart->quality;
//                        $merchandise->stockNum += $shoppingCart->quality;
//                        $merchandise->save();
//                    });
//                }
            }elseif(isset($activityId) && $activityId){
                /** @var ShoppingCart[]|Collection $shoppingCarts */
                $shoppingCarts = $this->shoppingCartRepository->with(['activityMerchandise'])->findWhere([
                    'activity_id' => $activityId,
                    'customer_id' => $user['id'],
                    'type' => $type
                ]);
                $whereFields = [];
                foreach ($shoppingCarts as $v){
                    $deleteIds[] = $v->id;
                    $whereFields[] = [
                        'activity_id' => $v->activityId,
                        'merchandise_id' => $v->merchandiseId
                    ];
                }
                /** @var Collection $merchandises */
//                $merchandises = $this->activityMerchandiseRepository->findWhere($whereFields);
//                if($merchandises && $merchandises->count() > 0) {
//                    $merchandises->map(function (ActivityMerchandise $merchandise) use ($shoppingCarts) {
//                        /** @var ShoppingCart $shoppingCart */
//                        $shoppingCart = $shoppingCarts->where([
//                            'activity_id' => $merchandise->activityId,
//                            'merchandise_id' => $merchandise->merchandiseId
//                        ])->first();
//                        $merchandise->sellNum -= $shoppingCart->quality;
//                        $merchandise->stockNum += $shoppingCart->quality;
//                        $merchandise->save();
//                    });
//                }
            }else{
                /** @var ShoppingCart[] $shoppingCarts */
                $shoppingCarts = $this->shoppingCartRepository->findWhere([
                    'customer_id'=>$user['id'],
                    'shop_id' => null,
                    'activity_id' => null,
                    'type' => $type
                ]);
                $whereFields = [];
                foreach ($shoppingCarts as $v){
                    $deleteIds[] = $v->id;
                    $whereFields[] = [
                        'id' => $v->merchandiseId
                    ];
                }
                /** @var Collection $merchandises */
//                $merchandises = $this->merchandiseRepository->findWhere($whereFields);
//                if($merchandises && $merchandises->count() > 0) {
//                    $merchandises->map(function (Merchandise $merchandise) use ($shoppingCarts) {
//                        /** @var ShoppingCart $shoppingCart */
//                        $shoppingCart = $shoppingCarts->where([
//                            'merchandise_id' => $merchandise->id
//                        ])->first();
//                        $merchandise->sellNum -= $shoppingCart->quality;
//                        $merchandise->stockNum += $shoppingCart->quality;
//                        $merchandise->save();
//                    });
//                }
            }


            $item = ShoppingCart::destroy($deleteIds);
            return $this->response(new JsonResponse(['delete_count' => $item]));
        });
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
     * @return \Dingo\Api\Http\Response
     */
    public function bookingMallShoppingCartMerchandises(){
        return $this->shoppingCartMerchandises();
    }


    /**
     * 获取购物车商品信息
     * @param int $storeId
     * @param int|null $activityId
     * @param string $type
     * @return \Dingo\Api\Http\Response
     */

    public function shoppingCartMerchandises(int $storeId = null,int $activityId = null, string $type = ShoppingCart::USER_ORDER){
        $user = $this->mpUser();
        $userId = $user->id;
        $items  = $this->shoppingCartRepository->shoppingCartMerchandises($storeId ,$activityId ,$userId, $type);
        return $this->response()->paginator($items, new ShoppingCartTransformer);
    }

    /**
     * 预定商城购物车
     * @return \Dingo\Api\Http\Response
     */
    public function merchantShoppingCartMerchandises(){
        $user = $this->mpUser();
        $shop = Shop::whereUserId($user->memberId)->first();
        if (!$shop) {
            throw new ModelNotFoundException('不是店主无法请求此接口');
        }
        return $this->shoppingCartMerchandises($shop->id, null, ShoppingCart::MERCHANT_ORDER);
    }

    /**
     * 新品预定获取常用地址
     * @param int $activityId
     * @param OrderRepository $repository
     * @return \Dingo\Api\Http\Response
     */
    public function activityUsuallyReceivingStores(int $activityId, OrderRepository $repository)
    {
        $user = $this->mpUser();
        $receivingShopOrders = $repository->activityUsuallyReceivingStores($activityId, $user->id);
        return $this->response()->paginator($receivingShopOrders,new UsuallyStoreAddressTransformer());
    }


    public function addMerchantShoppingCart(MerchantShoppingCartAddRequest $request)
    {
        $merchandise = $this->merchandiseRepository->findWhere([
            'id'=>$request->input('merchandise_id')
        ])->first();

        if(!$merchandise) {
            throw new ModelNotFoundException('产品不存在');
        }

        if ($merchandise['stock_num'] <= $request->input('quality')){
            throw new StoreResourceFailedException('商品库存不足');
        }
        $user = $this->shopManager();
        $shop = Shop::whereUserId($user->id)->first();
        if (!$shop) {
            throw new ModelNotFoundException('不是店主无法请求此接口');
        }
        $shoppingCart['quality'] = $request->input('quality');
        $shoppingCart['merchandise_id'] = $request->input('merchandise_id');
        $shoppingCart['type'] = ShoppingCart::MERCHANT_ORDER;
        $shoppingCart['shop_id'] = $shop->id;
        $shoppingCart['batch'] = $request->input('batch', 0);
        $shoppingCart['date'] = $request->input('date', Carbon::now()->format('Y-m-d'));

        return $this->shoppingCartAddMerchandise($shoppingCart, $merchandise);
    }

    /**
     * 清空店铺购物车
     * @return \Dingo\Api\Http\Response
     */
    public function clearMerchantShoppingCart(){
        $user = $this->shopManager();
        $shop = Shop::whereUserId($user->id)->first();
        if (!$shop) {
            throw new ModelNotFoundException('不是店主无法请求此接口');
        }
        return $this->clearShoppingCart($shop->id, null, ShoppingCart::MERCHANT_ORDER);
    }


    public function saveMerchantShoppingCart(Request $request)
    {
        $ids = $request->input('shopping_cart_ids', null);
        $name = $request->input('name', null);

        $user = $this->mpUser();
        $shop = Shop::whereUserId($user->memberId)->first();
        if (!$shop) {
            throw new ModelNotFoundException('没有店铺无法访问');
        }

        if (!$ids) {
            $carts = $this->shoppingCartRepository
                ->findWhere(['customer_id' => $user->id, 'shop_id'=> $shop->id, 'type' => ShoppingCart::MERCHANT_ORDER], ['id']);
            $ids = with($carts, function (Collection $collection) {
                return $collection->map(function ($item) {
                    return $item['id'];
                })->all();
            });
        }
        if (!$ids || !is_array($ids) || !$name) {
            throw new HttpValidationException('参数错误');
        } else {
            $user = $this->shopManager();
            $shop = Shop::whereUserId($user->id)->first();
            if (!$shop) {
                throw new ModelNotFoundException('不是店主无法请求此接口');
            }
            $shoppingCarts = ShoppingCart::whereIn('id', $ids)->where('shop_id', $shop->id)->get();
            if (!$shoppingCarts || $shoppingCarts->count() === 0) {
                throw new ModelNotFoundException('购物车不存在');
            }else{
                try {
                    $storeShoppingCart = new StoreShoppingCart();

                    $storeShoppingCart->appId = $shop->appId;
                    $storeShoppingCart->name = $name;
                    $storeShoppingCart->shopId = $shop->id;

                    $storeShoppingCart->shoppingCarts = $shoppingCarts->map(function (ShoppingCart $cart) {
                        return $cart->only(['app_id','shop_id','member_id','customer_id','merchandise_id','sku_product_id','quality','sell_price','amount'
                            ,'activity_id', 'type', 'batch', 'date']);
                    });
                    $storeShoppingCart->save();
                    return $this->response(new JsonResponse([
                        'message' => '保存成功'
                    ]));
                }catch (\Exception $exception) {
                    Log::info('error massage '.$exception->getMessage());
                    Log::info('error', $exception->getTrace());
                    throw new ModelNotFoundException('保存失败');
                }

            }
        }
    }

    public function merchantSavedShoppingCarts(Request $request)
    {
        $user = $this->shopManager();
        $shop = Shop::whereUserId($user->id)->first();
        if (!$shop) {
            throw new ModelNotFoundException('不是店主无法请求此接口');
        }
        $count =StoreShoppingCart::where('shop_id', $shop->id)->count();
        $shoppingCarts = StoreShoppingCart::where('shop_id', $shop->id)
            ->paginate($request->input('limit', $count));
        return $this->response()->paginator($shoppingCarts, new StoreShoppingCartTransformer());
    }

    public function useMerchantSavedShoppingCart(int $id)
    {
        $shoppingCart = StoreShoppingCart::find($id);
        if ($shoppingCart) {
            try {
                $user = $this->shopManager();
                $shop = Shop::whereUserId($user->id)->first();
                ShoppingCart::where('shop_id', $shop->id)->where('type',ShoppingCart::MERCHANT_ORDER)->delete();
                collect($shoppingCart->shoppingCarts)->map(function ($item) {
                    $cart = new ShoppingCart($item);
                    $cart->save();
                });
                return $this->response(new JsonResponse([
                    'message' => '成功'
                ]));
            }catch (\Exception $exception) {
                throw new ModelNotFoundException('恢复错误');
            }


        } else {
            throw new ModelNotFoundException('购物车记录不存在');
        }
    }
}