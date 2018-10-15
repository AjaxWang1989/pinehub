<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\MpUser;
use App\Http\Requests\CreateRequest;
use App\Repositories\MpUserRepository;
use App\Repositories\AppRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use App\Repositories\CustomerTicketCardRepository;
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
use App\Http\Response\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Services\Wechat\MpBizDataCrypt;

class AuthController extends Controller
{
    protected  $mpUserRepository = null;
    protected  $shopRepository = null;
    protected  $userRepository = null;
    protected  $customerTicketCardRepository = null;

    /**
     * AuthController constructor.
     * @param MpUserRepository $mpUserRepository
     * @param AppRepository $appRepository
     * @param ShopRepository $shopRepository
     * @param Request $request
     */
    public function __construct(MpUserRepository $mpUserRepository,CustomerTicketCardRepository $customerTicketCardRepository,UserRepository $userRepository,ShopRepository $shopRepository,AppRepository $appRepository, Request $request)
    {
        parent::__construct($request, $appRepository);
        $this->mpUserRepository = $mpUserRepository;
        $this->appRepository = $appRepository;
        $this->shopRepository = $shopRepository;
        $this->userRepository = $userRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
    }
    /**
     * 注册
     * @param Request $request
     * @throws
     * */

    public function registerUser(CreateRequest $request)
    {
        $session = $this->session();
        $currentApp = app(AppManager::class)->currentApp;
        list($errCode, $data) = app()->makeWith('bizDataCrypt', [$currentApp,
            $session['session_key']])->decryptData($request->input('encrypted_data'),
            $request->input('iv') );
        if ($errCode == 0) {
            $mpUser = $this->mpUserRepository->create($data);
            $param = array('platform_app_id'=>$mpUser['platform_app_id'],'password'=>$mpUser['session_key']);
            $token = Auth::attempt($param);
            $mpUser['token'] = $token;
            return $this->response()->item($mpUser, new MpUserTransformer());
        } else {
            return $this->response(new JsonResponse(['err_code' => $errCode]));
        }

    }

    /**
     * 获取用户信息
     * @return \Dingo\Api\Http\Response
     */
    public function userInfo()
    {
        $user = $this->mpUser();
        $user['ticket_num'] = count($this->customerTicketCardRepository->findWhere(['customer_id'=>$user['id']]));
        if ($user['member_id']){
            $shopUser = $this->shopRepository->findWhere(['user_id'=>$user['member_id']])->first();
            $user['shop_id'] = $shopUser['id'];
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

    public function appAccess(string $appid, string $appsecret)
    {
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

    public function mvpLogin(string $code, Request $request)
    {
        $accessToken = $request->input('access_token', null);
//        $mpSession = app('wechat')->miniProgram()->auth->session($code);
        $mpSession = ['open_id'=>'xcx0987654321','session_key'=>'tiihtNczf5v6AKRyjwEUhQ=='];
        cache([$accessToken.'_session'=> $mpSession], 60);
        if($mpSession && ($mpUser = $this->mpUserRepository->findByField('platform_open_id', $mpSession['open_id'])->first())) {
            $param = array('platform_open_id'=>$mpUser['platform_open_id'],'password'=>$mpUser['session_key']);
            $token = Auth::attempt($param);
            $mpUser['token'] = $token;
            return $this->response()->item($mpUser, new MvpLoginTransformer());
        }
        return $this->response(new JsonResponse(['user_info' => $mpSession]));
    }

    /**
     * 保存手机号
     * @param string $code
     * @return \Dingo\Api\Http\Response
     */
    public function saveMobile(Request $request)
    {
        $mpUser = $this->mpUser();
        $session = $this->session();
        $currentApp = app(AppManager::class)->currentApp;

        list($errCode, $data) = app()->makeWith('bizDataCrypt', [$currentApp,
            $session['session_key']])->decryptData($request->input('encrypt_data'),
            $request->input('iv') );

        if ($errCode == 0){
            $user = $mpUser->only(['nickname', 'city', 'province', 'city', 'avatar',
                'can_use_score', 'total_score', 'score', 'sex']);
            $user['mobile'] = $data['phoneNumber'];
            $member = $this->userRepository->create($user);
            $mpUser->mobile = $user['mobile'];
            $member->customers()->save($mpUser);
            return $this->response(new JsonResponse(['user_info' => $user]));
        }else{
            return $this->response(new JsonResponse(['err_code' => $errCode]));
        }
    }
}