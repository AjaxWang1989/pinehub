<?php

namespace App\Listeners;

use App\Entities\App;
use App\Entities\WechatConfig;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Unauthorized;

class OpenPlatformUnauthorized
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
     * @param  Unauthorized  $event
     * @return void
     */
    public function handle(Unauthorized $event)
    {
        //
        $wechatAppId = $event->getAuthorizerAppid();
        $app = App::whereWechatAppId($wechatAppId)->first();
        if($app) {
            $app->wechatAppId = null;
            $app->save();
        }
        $wechat = WechatConfig::whereAppId($wechatAppId)->first();
        $wechat->wechatBindApp = null;
        $wechat->authInfoType = WechatConfig::UNAUTHORIZED;
        $wechat->save();
    }
}
