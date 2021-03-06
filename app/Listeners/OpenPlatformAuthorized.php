<?php

namespace App\Listeners;

use App\Entities\WechatConfig;
use App\Repositories\AppRepository;
use App\Repositories\WechatConfigRepository;
use App\Services\Wechat\Components\MiniProgramAuthorizerInfo;
use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;
use Illuminate\Support\Facades\Cache;
use App\Entities\App;
use App\Services\Wechat\Components\OfficialAccountAuthorizerInfo;
use Carbon\Carbon;

class OpenPlatformAuthorized
{
    protected $wechatRepository = null;

    protected $wechat = null;

    protected $appRepository = null;
    /**
     * Create the event listener.
     * @param WechatConfigRepository $wechatConfigRepository
     * @param AppRepository $appRepository
     * @return void
     */
    public function __construct(WechatConfigRepository $wechatConfigRepository, AppRepository $appRepository)
    {
        //
        $this->appRepository = $appRepository;
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

    /**
     * @throws
     * */
    protected function componentAuthorized(Authorized $authorized)
    {
        $where = [];
        $attributes = [];
        $expiresIn = null;

        $appId = $authorized->getSysAppId();
        $where['app_id'] = $authorized->getAuthorizerAppid();
        $attributes['auth_code'] = $authorized->getAuthorizationCode();
        $attributes['auth_code_expires_in'] = Carbon::createFromTimestamp($authorized->getAuthorizationCodeExpiredTime());
        $attributes['auth_info_type'] = 'authorized';

        $wechatInfo = $this->wechatRepository->updateOrCreate($where,$attributes);

        /**
         * @var App
         * */
        $app = $appId ? $this->appRepository->find($appId) : null;

        $authorizer = $this->wechat->openPlatformAuthorizer($attributes['auth_code']);
        $componentAccessToken = $this->wechat->openPlatformComponentAccess();
        /**
         * @var OfficialAccountAuthorizerInfo|MiniProgramAuthorizerInfo
         * */
        $authInfo = $this->wechat->getOpenPlatformAuthorizer($where['app_id']);

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
                        $account = $this->wechat->openPlatform()->officialAccount($config->appId, $config->authorizerRefreshToken)->account->getBinding();
                        if($account && $account['errcode'] !== 0) {
                            $account = $this->wechat->openPlatform()->officialAccount($config->appId, $config->authorizerRefreshToken)->account->create();
                        }
                        $app->openAppId = $account['open_appid'];
                    }
                    $this->wechat->openPlatform()->officialAccount($config->appId, $config->authorizerRefreshToken)->account->bindTo($app->openAppId);
                }else{
                    if(!$app->openAppId) {
                        $account = $this->wechat->openPlatform()->miniProgram($config->appId, $config->authorizerRefreshToken)->account->getBinding();
                        if($account && $account['errcode'] !== 0) {
                            $account = $this->wechat->openPlatform()->miniProgram($config->appId, $config->authorizerRefreshToken)->account->create();
                        }
                        $app->openAppId = $account['open_appid'];
                    }
                    $this->wechat->openPlatform()->miniProgram($config->appId, $config->authorizerRefreshToken)->account->bindTo($app->openAppId);
                }
            }
        });
        if(isset($app)) {
            if($authInfo instanceof OfficialAccountAuthorizerInfo) {
                tap($app, function (App $app) use($wechatInfo){
                    $app->wechatAppId = $wechatInfo->appId;
                    $app->save();
                });
            }else{
                tap($app, function (App $app) use($wechatInfo){
                    $app->miniAppId = $wechatInfo->appId;
                    $app->save();
                });
            }
        }

    }
}
