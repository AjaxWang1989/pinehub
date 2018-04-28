<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryEloquent;
use App\Transformers\UserDetailTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class MySelfController extends Controller
{
    //
    protected $userModel = null;

    public function __construct(UserRepositoryEloquent $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param Request $request
     * @return  Response|null
     * @throws
     * */
    public function changePassword(Request $request)
    {
        $user = $this->user();
        if(!$request->input('password', null)){
            $this->response()->errorInternal('没有填写修改后密码');
        }
        $result = $this->userModel->update($request->only(['password']), $user->id);
        return $this->response()->item($result, new UserDetailTransformer());
    }
    /**
     * @param Request $request
     * @return  Response|null
     * @throws
     * */
    public function updateProfile(Request $request)
    {
        $user = $this->user();
        $result = $this->userModel->update($request->only(['nickname', 'user_name', 'sex', 'avatar', 'city']), $user->id);
        return $this->response()->item($result, new UserDetailTransformer());
    }

    public function forgotPassword(Request $request)
    {
        $code = $request->input('code', null);
        $time = $request->input('time', null);
        if($code === null || $time){
            $this->response()->errorInternal('缺少验证码');
        }

        if(!$request->input('password', null)){
            $this->response()->errorInternal('未填写密码');
        }

        $mobile = Cache::get(Hash::make($code,[
            'time' =>$time
        ]));
        $user = $this->userModel->first(['mobile' => $mobile]);
        $user->password = $request->input('password');
        $user->save();
        return $this->response()->item($user, new UserDetailTransformer());
    }

    public function selfInfo()
    {
        return $this->response()->item($this->user(), new UserDetailTransformer());
    }
}
