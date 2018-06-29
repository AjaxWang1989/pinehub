<?php

namespace App\Http\Controllers\Wechat;

use App\Entities\App;
use App\Entities\WechatConfig;
use App\Events\WechatSubscribeEvent;
use App\Http\Response\JsonResponse;
use App\Repositories\AppRepository;
use App\Repositories\WechatConfigRepository;
use App\Services\Wechat\Components\MiniProgramAuthorizerInfo;
use App\Services\Wechat\Components\OfficialAccountAuthorizerInfo;
use App\Services\Wechat\OpenPlatform\Guard;
use App\Transformers\AppTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use EasyWeChat\OpenPlatform\Application;
use EasyWeChat\OpenPlatform\Auth\VerifyTicket;
use EasyWeChat\OpenPlatform\Server\Handlers\VerifyTicketRefreshed as VerifyTicketHandle;
use Overtrue\LaravelWeChat\Events\OpenPlatform\VerifyTicketRefreshed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Overtrue\LaravelWeChat\Controllers\OpenPlatformController as Controller;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;

class OpenPlatformController extends Controller
{
    //
    use Helpers;
    protected $wechat = null;
    protected $appRepository = null;

    protected $wechatRepository = null;

    public function __construct(AppRepository $appRepository, WechatConfigRepository $wechatConfigRepository)
    {
        $this->wechat = app('wechat');
        $this->appRepository = $appRepository;
        $this->wechatRepository = $wechatConfigRepository;
        Event::listen(Authorized::class, function (Authorized $authorized) {
            $this->componentAuthorized($authorized);
        });

        Event::listen(VerifyTicketRefreshed::class, function (VerifyTicketRefreshed $ticketRefreshed) {
            $this->verifyTicketRefresh($ticketRefreshed);
        });
        Event::listen(WechatSubscribeEvent::class, function (WechatSubscribeEvent $event) {
           $this->subscribed($event);
        });
        //监听事件
    }

    public function __invoke(Application $application)
    {
        $server = $application->server;
        $server->on(Guard::EVENT_SUBSCRIBE, function ($payload) {
            Event::fire(new WechatSubscribeEvent($payload));
        });
        return parent::__invoke($application); // TODO: Change the autogenerated stub
    }

    protected function verifyTicketRefresh(VerifyTicketRefreshed $ticketRefreshed)
    {
        $app = $this->wechat->openPlatform();
        tap($app['verify_ticket'], function (VerifyTicket $ticket) use($ticketRefreshed){
            $ticket->setTicket($ticketRefreshed->getComponentVerifyTicket());
        });
    }

    protected function subscribed(WechatSubscribeEvent $event)
    {
        //
        $user = null;
        Event::dispatch(SEND_FOCUS_CARD_EVENT, $user);
    }

    protected function componentAuthorized(Authorized $authorized)
    {
        $this->wechatRepository->updateOrCreate(['app_id' => $authorized->getAuthorizerAppid()], [
            'auth_code' => $authorized->getAuthorizationCode(),
            'auth_code_expires_in' => Carbon::now()->addMinute((int)$authorized->getAuthorizationCodeExpiredTime()),
            'info_type' => $authorized->getInfoType()
        ]);
        $cacheKey = CURRENT_APP_PREFIX.$authorized->getAuthorizationCode();
        $appId = Cache::get($cacheKey, null);
        if($appId) {
            $app = $this->appRepository->find($appId);
            Cache::delete($cacheKey);
        }else{
            Cache::set($cacheKey, $authorized->getAuthorizationAppid(), (int)$authorized->getAuthorizationCodeExpiredTime());
        }

        $authorizer = $this->wechat->openPlatformAuthorizer($authorized->getAuthorizationCode());
        $componentAccessToken = $this->wechat->openPlatformComponentAccess();
        /**
         * @var OfficialAccountAuthorizerInfo|MiniProgramAuthorizerInfo
         * */
        $authInfo = $this->wechat->getOpenPlatformAuthorizer($authorized->getAuthorizerAppid());

        $wechatInfo = $this->wechatRepository->findByField('app_id', $authorized->getAuthorizerAppid())->first();
        tap($wechatInfo, function (WechatConfig &$config) use($authInfo, $authorized, $authorizer, $appId, $componentAccessToken) {
            $config->alias = $authInfo->getAlias();
            $config->nickname = $authInfo->getNickname();
            $config->authorizerAccessToken = $authorizer->authorizerAccessToken;
            $config->authorizerAccessTokenExpiresIn = $authorizer->expiresIn;
            $config->authorizerRefreshToken = $authorizer->authorizerRefreshToken;
            $config->userName = $authInfo->userName;
            $config->funcInfo = $authInfo->authorizationInfo['func_info'];
            $config->wechatBindApp = $appId;
            $config->headImg = $authInfo->headImg;
            $config->componentAccessToken = $componentAccessToken->componentAccessToken;
            $config->componentAccessTokenExpiresIn = $componentAccessToken->expiresIn;
            $config->qrcodeUrl = $authInfo->qrcodeUrl;
            $config->businessInfo = $authInfo->businessInfo;
            $config->principalName = $authInfo->principalName;
            $config->serviceTypeInfo = $authInfo->serviceTypeInfo;
            $config->verifyTypeInfo = $authInfo->verifyTypeInfo;
            $config->miniProgramInfo = $authInfo->miniProgramInfo;
            $config->type = $config->miniProgramInfo ? WECHAT_MINI_PROGRAM : WECHAT_OFFICIAL_ACCOUNT;
            $config->save();
        });
        if(isset($app)) {
            if($authInfo instanceof OfficialAccountAuthorizerInfo) {
                tap($app, function (App $app) use($authorized){
                    $app->wechatAppId = $authorized->getAuthorizerAppid();
                    $app->save();
                });
            }else{
                tap($app, function (App $app) use($authorized){
                    $app->miniAppId = $authorized->getAuthorizerAppid();
                    $app->save();
                });
            }
        }

    }

    public function componentLoginAuth(Request $request)
    {
        $appId = $request->input('app_id', null);
        $token = $request->input('token', null);
        Cache::set(CURRENT_APP_PREFIX.$request->input('token'), $appId, 3600);
        return view('open-platform.auth')->with('authUrl', $this->wechat->openPlatformComponentLoginPage($appId, $token))->with('success', false);
    }


    public function componentLoginCallback(string $appId, Request $request)
    {
        $app = $this->appRepository->find($appId);
        $authCode = $request->input('auth_code', null);
        $expiresIn = $request->input('expires_in', null);
        $cacheAuthCodeKey = CURRENT_APP_PREFIX.$authCode;
        $wechatAppid = Cache::get($cacheAuthCodeKey, null);
        if($wechatAppid) {
            Cache::delete($cacheAuthCodeKey);
            $wechatMap = $this->wechatRepository->findByField('app_id', $wechatAppid);
            tap($app, function (App $app) use($wechatMap){
                $wechatMap->map(function (WechatConfig $config) use($app){
                    if($config->type === WECHAT_OFFICIAL_ACCOUNT) {
                        $app->wechatAppId = $config->appId;
                    } else {
                        $app->miniAppId = $config->appId;
                    }
                    $config->wechatBindApp = $app->id;
                    $config->save();
                    $app->save();
                });
            });
        }else{
            if($app && $authCode && $expiresIn) {
                Cache::set($cacheAuthCodeKey, with($app, function (App $app) {
                    return $app->id;
                }), $expiresIn);

                Cache::set(CURRENT_APP_PREFIX.$request->input('token'), [$appId, $authCode], $expiresIn);
            }
        }
        return redirect('open-platform.auth')->with('success', true);
    }

    public function openPlatformAuthMakeSure(Request $request)
    {
        $auth = Cache::get(CURRENT_APP_PREFIX.$request->input('token'), false);
        if($auth) {
            $app = $this->appRepository->find($request->input('app_id'));
            return $this->response(new JsonResponse($auth));
        }
        $this->response()->error('未完成授权，请等待');
    }

}
