<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:47
 */

namespace App\Http\Controllers\MiniProgram;

use App\Entities\App;
use App\Entities\Card;
use App\Entities\Customer;
use App\Entities\CustomerTicketCard;
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
use App\Transformers\Mp\AppAccessTransformer;
use App\Transformers\Mp\MvpLoginTransformer;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Response\JsonResponse;
use App\Exceptions\UserCodeException;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    /**
     * @var MpUserRepository|null
     */
    protected  $mpUserRepository = null;

    /**
     * @var ShopRepository|null
     */
    protected  $shopRepository = null;

    /**
     * @var UserRepository|null
     */
    protected  $userRepository = null;

    /**
     * @var CustomerTicketCardRepository|null
     */
    protected  $customerTicketCardRepository = null;


    /**
     * AuthController constructor.
     * @param MpUserRepository $mpUserRepository
     * @param CustomerTicketCardRepository $customerTicketCardRepository
     * @param UserRepository $userRepository
     * @param ShopRepository $shopRepository
     * @param AppRepository $appRepository
     * @param Request $request
     */
    public function __construct( MpUserRepository $mpUserRepository,
                                CustomerTicketCardRepository $customerTicketCardRepository,
                                UserRepository $userRepository,
                                ShopRepository $shopRepository,
                                AppRepository $appRepository,
                                Request $request )
    {
        parent::__construct($request, $appRepository);

        $this->mpUserRepository             = $mpUserRepository;
        $this->appRepository                = $appRepository;
        $this->shopRepository               = $shopRepository;
        $this->userRepository               = $userRepository;
        $this->customerTicketCardRepository = $customerTicketCardRepository;
    }

    /**
     * 注册
     * @param CreateRequest $request
     * @return AuthController|\Dingo\Api\Http\Response|
     * \Dingo\Api\Http\Response\Factory|\Illuminate\Foundation\Application|
     * \Laravel\Lumen\Application|mixed
     */

    public function wxRegisterUser(CreateRequest $request)
    {
        $session = $this->session();

        //获取小程序app_id
        $currentApp = app(AppManager::class)->currentApp;

        //根据小程序id和登陆接口返回的解析后的用户信息
        list($errCode, $data) = app()->makeWith('bizDataCrypt', [$currentApp, $session['session_key']])
            ->decryptData(urldecode($request->input('encrypted_data')), urldecode($request->input('iv')));
        Log::info("========= wx user data =========\n", [$data]);
        if ($errCode == 0) {

            /** @var MpUser $mpUser */
            $mpUser = $this->mpUserRepository
                ->findByField('platform_open_id', $data['openId'])
                ->first();

            if ($mpUser){
                $mpUser->platformOpenId = $data['openId'];
                $mpUser->nickname = $data['nickName'];
                $mpUser->sex = $data['gender'] === 1 ? MALE : ($data['gender'] === 2 ? FEMALE : UNKNOWN);
                $mpUser->type = WECHAT_MINI_PROGRAM;
                $mpUser->unionId = $data['unionId'];
                $mpUser->avatar = $data['avatarUrl'];
                $mpUser->country = $data['country'];
                $mpUser->city = $data['city'];
                $mpUser->province = $data['province'];
                $mpUser->sessionKey = $data['session_key'];
                $mpUser->appId = $data['app_id'];
                $mpUser->save();
            }else{
                $mpUser = new MpUser();
                $mpUser->platformOpenId = $data['openId'];
                $mpUser->nickname = $data['nickName'];
                $mpUser->sex = $data['gender'] === 1 ? MALE : ($data['gender'] === 2 ? FEMALE : UNKNOWN);
                $mpUser->type = WECHAT_MINI_PROGRAM;
                $mpUser->unionId = $data['unionId'];
                $mpUser->avatar = $data['avatarUrl'];
                $mpUser->country = $data['country'];
                $mpUser->city = $data['city'];
                $mpUser->province = $data['province'];
                $mpUser->sessionKey = $data['session_key'];
                $mpUser->appId = $data['app_id'];
                $mpUser = $this->mpUserRepository->create($mpUser->toArray());
            }
            $param = [
                'platform_open_id' => $mpUser['platform_open_id'],
                'password' => $mpUser['session_key']
            ];

            $token = Auth::attempt($param);

            $mpUser['token'] = $token;

            Cache::put($token.'_session', $session, 60);

            return $this->response()
                ->item($mpUser, new MpUserTransformer());
        } else {
            throw new UserCodeException($errCode);
        }
    }

    public function ticketsCount(MpUser $user) {
        return (new CustomerTicketCard)->where(['customer_id' => $user->id, 'status' => CustomerTicketCard::STATUS_ON])
            ->whereHas('card', function ($query){
                $query->whereIn('card_type', [Card::DISCOUNT, Card::CASH]);
                $query->where('app_id', app(AppManager::class)->getAppId());
            })->where('card_id','!=', '')
            ->count();
    }
    /**
     * 获取用户信息
     * @return \Dingo\Api\Http\Response
     */
    public function userInfo()
    {
        $user = $this->mpUser();

        $user['ticket_num'] = $this->ticketsCount($user);

        $shopUser = $this->shopRepository
            ->findWhere(['user_id' => $user['member_id']])
            ->first();

        $user['shop_id'] = isset($shopUser) ? $shopUser['id'] : null;
        $user['open_id'] = $user->platformOpenId;

        return $this->response()
            ->item($user, new MpUserInfoMobileTransformer());
    }

    /**
     * 判断是否为当前的小程序
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */

    public function appAccess(Request $request)
    {
        $request = $request->all();

        $item = $this->appRepository
            ->findWhere(['id'=>$request['app_id']])
            ->first();

        $sign = md5(md5($item['id'].$item['secret']).$request['timestamp']);

        if ($request['sign'] == $sign){
            $accessToken = Hash::make($item['id'], with($item, function (App $app) {
                return $app->toArray();
            }));

            app(AppManager::class)->setCurrentApp($item)
                ->setAccessToken($accessToken);

            $item['access_token'] = $accessToken;
            $item['ttl'] = Carbon::now()->addMinute(app(AppManager::class)->ttl)->format('Y-m-d H:i:s');

            return $this->response()
                ->item($item, new AppAccessTransformer());
        }else{
            $errCode = 'sign签名错误';
            throw new UserCodeException($errCode);
        }
    }

    /**
     * 用户登陆
     * @param string $code
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Exception
     */

    public function wxLogin(string $code, Request $request)
    {
        $accessToken = $request->input('access_token', null);

        $session = app('wechat')->miniProgram()
            ->auth
            ->session($code);

        cache([$accessToken.'_session'=> $session], config('jwt.ttl'));
        Log::info("==== wx session access token =======\n", cache("{$accessToken}_session"));
        $mpUser = $this->mpUserRepository
            ->findByField('platform_open_id', $session['openid'])
            ->first();

        if(!$mpUser)
            $mpUser = new MpUser();
        $now = Carbon::now();
        $mpSession = [
            'open_id' => $session['openid'],
            'session_key' => $session['session_key'],
            'over_date' => $now->copy()->addMinute( config('jwt.ttl'))->format('Y-m-d H:i:s')
        ];

        if($session) {
            $shopUser = $this->shopRepository
                ->findWhere(['user_id'  =>  $mpUser['member_id']])
                ->first();


            with($mpUser, function (MpUser $mpUser) use($session){
                if ($mpUser['member_id']){
                    $mpUser->member()->update([
                        'last_login_at' => Carbon::now()
                    ]);
                }

                $mpUser->platformOpenId = $session['openid'];
                $mpUser->sessionKey = $session['session_key'];
                $mpUser->save();

            });

            $mpUser['shop_id'] = isset($shopUser) ? $shopUser['id'] : null;

            $param = [
                'platform_open_id' => $mpUser['platform_open_id'],
                'password' => $mpUser['session_key']
            ];

            $token = Auth::attempt($param);
            Cache::put($token.'_session', $session,  config('jwt.ttl'));

            $mpUser['token'] = $token;

            return $this->response()
                ->item($mpUser, new MvpLoginTransformer());
        }

        return $this->response(new JsonResponse($mpSession));
    }

    /**
     * 保存手机号
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function saveMobile(Request $request)
    {
        $mpUser = $this->mpUser();

        $session = $this->session();

        $currentApp = app(AppManager::class)->currentApp;

        //解密手机号码
        list($errCode, $data) = app()->makeWith('bizDataCrypt', [$currentApp, $session['session_key']])
            ->decryptData(urldecode($request->input('encrypted_data')), urldecode($request->input('iv')));

        if ($errCode == 0) {
            $user = $mpUser->only(['nickname', 'city', 'province', 'city', 'avatar', 'can_use_score', 'total_score',
                'score', 'sex','app_id']);

            $user['mobile'] = $data['phoneNumber'];
            $user['user_name'] = $data['phoneNumber'];

            $member = $this->userRepository->findWhere(['mobile' => $user['mobile']])->first();
            if($member) {
                $member->update($user);
            }else{
                $member = $this->userRepository->create($user);
            }

            $mpUser->mobile = $user['mobile'];

            $member->customers()
                ->save($mpUser);

            return $this->response(new JsonResponse(['mobile' => $user['mobile']]));
        }else{
            throw new UserCodeException($errCode);
        }
    }

    public function aliLogin(string $code, MpUserRepository $customerRepository)
    {
        $token = app('alipay')->getToken($code);
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $aliAppId = config('ali.payment.app_id');
        Log::info('ali customer info', $token);

        /** @var Customer $customer */
        $customer = $customerRepository->updateOrCreate([
            'app_id' => $appId,
            'platform_app_id' => $aliAppId,
            'type' => Customer::ALIPAY_OPEN_PLATFORM,
            'platform_open_id' => $token['user_id'],
            'session_key' => $token['access_token']
        ], [
            'app_id' => $appId,
            'platform_app_id' => $aliAppId,
            'type' => Customer::ALIPAY_OPEN_PLATFORM,
            'platform_open_id' => $token['user_id']
        ]);

        $param = [
            'platform_open_id' => $customer->platformOpenId,
            'password' => $customer->sessionKey
        ];

        $token = Auth::attempt($param);

        $customer['token'] = $token;

        return $this->response()
            ->item($customer, new MvpLoginTransformer());
    }
}