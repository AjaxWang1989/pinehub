<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Shop;
use App\Entities\User;
use App\Http\Response\CreateResponse;
use App\Http\Response\UpdateResponse;
use App\Repositories\ShopRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\Api\UpdateResponseTransformer;
use App\Transformers\CreateResponeTransformer;
use App\Transformers\ShopDetailTransformer;
use App\Transformers\ShopsTransformer;
use App\Transformers\StoreDetailTransformer;
use App\Utils\GeoHash;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use GeoJson\Geometry\Point;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;

class ShopsController extends Controller
{
    //
    /**
     * @var UserRepositoryEloquent
     * */
    protected $userModel = null;

    /**
     * @var ShopRepositoryEloquent
     * */
    protected $shopModel = null;

    public function __construct(UserRepositoryEloquent $userModel, ShopRepositoryEloquent $shopModel)
    {
        $this->userModel = $userModel;
        $this->shopModel = $shopModel;
    }

    /**
     * 创建新店铺
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function store(Request $request)
    {
        $validator = $this->shopModel->makeValidator();
//        print_r($request->toArray()); exit();
        $validator->with($request->toArray());
        /** @var array $store */
        $attributes = $request->toArray();
        if(!isset($attributes['manager_name']) || !isset($attributes['manager_mobile'])){
            $this->response()->error('参数manager_name或者manager_mobile缺少',
                HTTP_STATUS_UNPROCESSABLE_ENTITY);
        }
        $attributes['user_id'] = $this->getOwner($attributes['manager_mobile'], $attributes['manager_name'])->id;
        unset($attributes['manager_mobile'], $attributes['manager_name']);
        if(isset($attributes['lat']) && isset($attributes['long'])){
            $attributes['position'] = new Point($attributes['lat'], $attributes['long']);
            $attributes['geo_hash'] = (new GeoHash())->encode($attributes['lat'], $attributes['long']);
            unset($attributes['lat'], $attributes['long']);
        }

        $store = $this->shopModel->create($attributes);
        if(!$store){
            $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $this->response()->item(new CreateResponse('店铺创建成功'), new CreateResponeTransformer());
    }

    /**
     * 更新店铺信息
     * @param integer $id
     * @return Response
     * @throws
     * */
    public function update(integer $id)
    {
        $validator = $this->shopModel->makeValidator();
        /** @var array $store */
        $store = $validator->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $store['user_id'] = $this->getOwner($store['manager_mobile'], $store['manager_name'])->id;
        unset($store['manager_mobile'], $store['manager_name']);
        $store = $this->shopModel->update($store, $id);
        if(!$store){
            $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $this->response()->item(new UpdateResponse('店铺信息更新成功'), new UpdateResponseTransformer());
    }

    /**
     * 获取店铺老板/经理人的用户信息
     * @param string $mobile
     * @param string $name
     * @return User
     * @throws
     * */
    protected function getOwner(string $mobile, string $name)
    {
        $user = $this->userModel->findWhere(['mobile' => $mobile])->first();
        if(!$user){
            $user = $this->userModel->create(['user_name' => $mobile, 'real_name' => $name, 'mobile' => $mobile]);
        }
        return $user;
    }

    /**
     * 店铺列表
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function getShops(Request $request)
    {
        $this->shopModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->shopModel->with(['shopManager', 'city', 'county'])->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($result, new ShopsTransformer);
    }

    /**
     * 店铺详情
     * @param int $id
     * @return Response
     * */
    public function getShopDetail(int $id)
    {
        $shop = $this->shopModel->with(['shopManager', 'city', 'county', 'orders.orderItems'])->find($id);
        if(!$shop){
            $this->response()->errorNotFound('没有找到对应的店铺信息');
        }
        return $this->response()->item($shop, new ShopDetailTransformer());
    }
}
