<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Repositories\ShopRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\ShopsTransformer;
use App\Transformers\StoreDetailTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Response;
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
     * @return Response
     * @throws
     * */
    public function store()
    {
        $validator = $this->shopModel->makeValidator();
        /** @var array $store */
        $store = $validator->passesOrFail(ValidatorInterface::RULE_CREATE);
        $store['user_id'] = $this->getOwner($store['manager_mobile'], $store['manager_name'])->id;
        unset($store['manager_mobile'], $store['manager_name']);
        $store = $this->shopModel->create($store);
        if(!$store){
            $this->response()->error('创建失败', HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
        return $this->response()->item($store, new StoreDetailTransformer);
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
        return $this->response()->item($store, new StoreDetailTransformer);
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
    public function getStores(Request $request)
    {
        $this->shopModel->pushCriteria(app(RequestCriteria::class));
        $result = $this->shopModel->with('manager')->paginate($request->input('limit', PAGE_LIMIT));
        return $this->response()->paginator($result, new ShopsTransformer);
    }

    public function getDetail()
    {

    }
}
