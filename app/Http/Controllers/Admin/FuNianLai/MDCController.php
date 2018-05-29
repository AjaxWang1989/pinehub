<?php

namespace App\Http\Controllers\Admin\FuNianLai;

use App\Entities\User;
use App\Http\Response\CreateResponse;
use App\Http\Response\UpdateResponse;
use App\Repositories\ShopRepositoryEloquent as MDCModel;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\Api\UpdateResponseTransformer;
use App\Transformers\CreateResponeTransformer;
use App\Transformers\ShopDetailTransformer;
use App\Transformers\ShopsTransformer;
use App\Utils\GeoHash;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
use Grimzy\LaravelMysqlSpatial\Types\Point as PointType;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;

class MDCController extends Controller
{
    //
    /**
     * @var UserRepositoryEloquent
     * */
    protected $userModel = null;

    /**
     * @var MDCModel
     * */
    protected $mdcModel = null;

    public function __construct(UserRepositoryEloquent $userModel, MDCModel $mdcModel)
    {
        $this->userModel = $userModel;
        $this->mdcModel = $mdcModel;
    }

    /**
     * 创建新店铺
     * @param Request $request
     * @return Response
     * @throws
     * */
    public function store(Request $request)
    {
        $validator = $this->mdcModel->makeValidator();
        $validator->with($request->toArray());
        /** @var array $store */
        $attributes = $request->only(['country_id', 'province_id', 'city_id', 'county_id', 'address', 'description', 'code']);
        if(!$request->input('manager_name', null) || !$request->input('manager_mobile', null)){
            $this->response()->error('参数manager_name或者manager_mobile缺少',
                HTTP_STATUS_UNPROCESSABLE_ENTITY);
        }
        $attributes['user_id'] = $this->getOwner($request->input('manager_mobile', null), $request->input('manager_name', null))->id;
        if($request->input('lat', null) && $request->input('lng', null)){
            $attributes['position'] = new PointType($request->input('lat'), $request->input('lng'));
            $attributes['geo_hash'] = (new GeoHash())->encode($request->input('lat'), $request->input('lng'));
        }

        $store = $this->mdcModel->create($attributes);
        if(!$store){
            $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $this->response()->item(new CreateResponse('店铺创建成功'), new CreateResponeTransformer());
    }

    /**
     * 更新店铺信息
     * @param  int $id
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(int $id)
    {
        $validator = $this->mdcModel->makeValidator();
        /** @var array $store */
        $store = $validator->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $store['user_id'] = $this->getOwner($store['manager_mobile'], $store['manager_name'])->id;
        unset($store['manager_mobile'], $store['manager_name']);
        $store = $this->mdcModel->update($store, $id);
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
            $user = $this->userModel->create(['user_name' => $mobile, 'password' => password($mobile),'real_name' => $name, 'mobile' => $mobile]);
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
        $this->mdcModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->mdcModel->with(['shopManager', 'city', 'county'])->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($result, new ShopsTransformer);
    }

    /**
     * 店铺详情
     * @param int $id
     * @return Response
     * */
    public function getShopDetail(int $id)
    {
        $shop = $this->mdcModel->with(['shopManager', 'city', 'county', 'orders.orderItems'])->find($id);
        if(!$shop){
            $this->response()->errorNotFound('没有找到对应的店铺信息');
        }
        return $this->response()->item($shop, new ShopDetailTransformer());
    }
}
