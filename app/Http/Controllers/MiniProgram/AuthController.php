<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\MiniProgram;

use App\Http\Requests\CreateRequest;
use App\Repositories\MpUserRepository;
use App\Repositories\AppRepository;
use App\Repositories\WechatUserRepository;
use App\Services\AppManager;
use App\Transformers\Mp\MpUserTransformer;
use App\Transformers\Mp\MpUserInfoMobileTransformer;
use App\Transformers\Mp\MpUserInfoTransformer;
use App\Transformers\Mp\AppAccessTransformer;
use App\Transformers\Mp\MvpLoginTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected  $mpUserRepository = null;
    protected  $wechatUserRepository = null;

    /**
     * AuthController constructor.
     * @param MpUserRepository $mpUserRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct(MpUserRepository $mpUserRepository,WechatUserRepository $wechatUserRepository,AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->mpUserRepository = $mpUserRepository;
        $this->appRepository = $appRepository;
        $this->wechatUserRepository = $wechatUserRepository;
    }
    /**
     * 注册
     * @param Request $request
     * @throws
     * */

    public function registerUser(CreateRequest $request){
        $mpUser = $request->all();
        $mpUser = $this->mpUserRepository->create($mpUser);
        $param = array('platform_app_id'=>$mpUser['platform_app_id'],'password'=>$mpUser['session_key']);
        $token = Auth::attempt($param);
        $mpUser['token'] = $token;
        return $this->response()->item($mpUser, new MpUserTransformer());
    }

    /**
     * 获取用户信息
     * @return \Dingo\Api\Http\Response
     */
    public function userInfo(){
        $user = $this->user();
        if ($user['mobile']){
            return $this->response()->item($user, new MpUserInfoMobileTransformer());
        }else{
            return $this->response()->item($user, new MpUserInfoTransformer());
        }

    }

    /**
     * 判断是否为当前的小程序
     * @param string $appid
     * @param string $appsecret
     * @return \Dingo\Api\Http\Response
     */

    public function appAccess(string $appid, string $appsecret){
        $item = $this->appRepository->findWhere(['id'=>$appid,'secret'=>$appsecret])->first();
        $accessToken = Hash::make($appid,$item->toArray());
        app(AppManager::class)->setCurrentApp($item)->setAccessToken($accessToken);
        $item['access_token'] = $accessToken;
        return $this->response()->item($item, new AppAccessTransformer());
    }

    /**
     * 用户登陆
     * @param string $code
     * @return \Dingo\Api\Http\Response
     */

    public function mvpLogin(string $code){
        $mpSession = app('wechat')->miniProgram()->auth->session($code);
        if($mpSession && ($wechatUser = $this->wechatUserRepository->findByField('open_id', $mpSession['open_id']))) {
            $wechatUser = $this->wechatUserRepository->findByField('open_id',$mpSession['open_id'])->first();
            $param = array('open_id'=>$wechatUser['open_id'],'password'=>$wechatUser['session_key']);
            $token = Auth::attempt($param);
            $wechatUser['token'] = $token;
            return $this->response()->item($wechatUser, new MvpLoginTransformer());
        }
        return $mpSession;
    }

}