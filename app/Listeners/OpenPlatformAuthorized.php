<?php

namespace App\Listeners;

use App\Entities\WechatConfig;
use App\Repositories\WechatConfigRepository;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;
use Illuminate\Support\Facades\Cache;
use App\Entities\App;
use App\Services\Wechat\Components\OfficialAccountAuthorizerInfo;
use Carbon\Carbon;

class OpenPlatformAuthorized
{
    protected $wechatRepository = null;

    protected $wechat = null;
    /**
     * Create the event listener.
     * @param WechatConfigRepository $wechatConfigRepository
     * @return void
     */
    public function __construct(WechatConfigRepository $wechatConfigRepository)
    {
        //
        $this->wechatRepository = $wechatConfigRepository;
        $this->wechat = app('wechat');
    }

    /**
     * Handle the event.
     *
     * @param  Authorized  $event
     * @return void
     */
    public function handle(Authorized $event)
    {
        //
        $this->componentAuthorized($event);
    }

    protected function componentAuthorized(Authorized $authorized)
    {
        $this->wechatRepository->updateOrCreate(['app_id' => $authorized->getAuthorizerAppid()], [
            'auth_code' => $authorized->getAuthorizationCode(),
            'auth_code_expires_in' => Carbon::createFromTimestamp((int)$authorized->getAuthorizationCodeExpiredTime()),
            'auth_info_type' => $authorized->getInfoType()
        ]);
        $cacheKey = CURRENT_APP_PREFIX.$authorized->getAuthorizationCode();
        $appId = Cache::get($cacheKey, null);
        $app = null;
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

        tap($wechatInfo, function (WechatConfig &$config) use($authInfo, $authorized, $authorizer, $appId, $componentAccessToken, $app) {
            $config->alias = $authInfo->getAlias();
            $config->nickname = $authInfo->getNickname();
            $config->authorizerAccessToken = $authorizer->getAuthorizerAccessToken();
            $config->authorizerAccessTokenExpiresIn = $authorizer->getExpiresIn();
            $config->authorizerRefreshToken = $authorizer->getAuthorizerRefreshToken();
            $config->userName = $authInfo->getUserName();
            $config->funcInfo = $authInfo->getAuthorizationInfo()['func_info'];
            $config->wechatBindApp = $appId;
            $config->headImg = $authInfo->getHeadImg();
            $config->componentAccessToken = $componentAccessToken->getComponentAccessToken();
            $config->componentAccessTokenExpiresIn = $componentAccessToken->getExpiresIn();
            $config->qrcodeUrl = $authInfo->getQrcodeUrl();
            $config->businessInfo = $authInfo->getBusinessInfo();
            $config->principalName = $authInfo->getPrincipalName();
            $config->serviceTypeInfo = $authInfo->getServiceTypeInfo();
            $config->verifyTypeInfo = $authInfo->getVerifyTypeInfo();
            $config->miniProgramInfo = $authInfo->getMiniProgramInfo();
            $config->type = $config->miniProgramInfo ? WECHAT_MINI_PROGRAM : WECHAT_OFFICIAL_ACCOUNT;
            $config->save();
            if($appId) {
                if($config->type === WECHAT_OFFICIAL_ACCOUNT){
                    if(!$app->openAppId) {
                        $account = $this->wechat->openPlatform()->officialAccount($config->appId)->account->create();
                        $app->openAppId = $account['open_appid'];
                    }
                    $this->wechat->openPlatform()->officialAccount($config->appId)->account->bindTo($app->openAppId);
                }else{
                    if(!$app->openAppId) {
                        $account = $this->wechat->openPlatform()->miniProgram($config->appId)->account->create();
                        $app->openAppId = $account['open_appid'];
                    }
                    $this->wechat->openPlatform()->miniProgram($config->appId)->account->bindTo($app->openAppId);
                }
            }
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
}
