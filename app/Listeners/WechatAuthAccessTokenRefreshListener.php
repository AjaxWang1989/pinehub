<?php

namespace App\Listeners;

use App\Events\WechatAuthAccessTokenRefreshEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WechatAuthAccessTokenRefreshListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WechatAuthAccessTokenRefreshEvent  $event
     * @return void
     */
    public function handle(WechatAuthAccessTokenRefreshEvent $event)
    {
        //
        $wechat = $event->wechat;
        $now = time();
        if($wechat->authorizerAccessTokenExpiresIn->getTimestamp() < $now) {
            if($wechat->componentAccessTokenExpiresIn->getTimestamp() < $now) {
                $componentAccessToken = app('wechat')->openPlatformComponentAccess(true);
                $wechat->componentAccessToken = $componentAccessToken->getComponentAccessToken();
                $wechat->componentAccessTokenExpiresIn = $componentAccessToken->getExpiresIn();
            }
            $openPlatformAccessToken = app('wechat')->openPlatformOfficialAccountAccessToken($wechat->appId,
                $wechat->authorizerRefreshToken, true);
            $wechat->authorizerRefreshToken = $openPlatformAccessToken->authorizerAccessToken;
            $wechat->authorizerAccessToken = $openPlatformAccessToken->authorizerAccessToken;
            $wechat->authorizerAccessTokenExpiresIn = $openPlatformAccessToken->expiresIn;
            $wechat->save();
        }
    }
}
