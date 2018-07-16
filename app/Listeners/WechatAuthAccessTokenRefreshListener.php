<?php

namespace App\Listeners;

use App\Events\WechatAuthAccessTokenRefreshEvent;
use App\Services\AppManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class WechatAuthAccessTokenRefreshListener extends AsyncEventListener
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
        $appManager = app(AppManager::class);
        $appManager->setCurrentApp($wechat->app);
        Log::debug('current app', [$wechat->app]);
        if($wechat->authorizerAccessTokenExpiresIn->getTimestamp() < $now) {
            if($wechat->componentAccessTokenExpiresIn->getTimestamp() < $now) {
                $componentAccessToken = app('wechat')->openPlatformComponentAccess();
                if($wechat->componentAccessToken !== $componentAccessToken->componentAccessToken){
                    $wechat->componentAccessToken = $componentAccessToken->componentAccessToken;
                    $wechat->componentAccessTokenExpiresIn = $componentAccessToken->expiresIn;
                }

            }
            $openPlatformAccessToken = app('wechat')->openPlatformOfficialAccountAccessToken();
            if($wechat->authorizerAccessToken !== $openPlatformAccessToken->authorizerAccessToken) {
                $wechat->authorizerRefreshToken = $openPlatformAccessToken->authorizerRefreshToken;
                $wechat->authorizerAccessToken = $openPlatformAccessToken->authorizerAccessToken;
                $wechat->authorizerAccessTokenExpiresIn = $openPlatformAccessToken->expiresIn;
            }

            $wechat->save();
        }
    }
}
