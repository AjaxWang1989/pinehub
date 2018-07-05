<?php

namespace App\Listeners;

use App\Entities\WechatConfig;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Overtrue\LaravelWeChat\Events\OpenPlatform\UpdateAuthorized;

class OpenPlatformUpdateAuthorized
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
     * @param  UpdateAuthorized  $event
     * @return void
     */
    public function handle(UpdateAuthorized $event)
    {
        //
        $wechatAppid = $event->getAuthorizerAppid();
        $wechat = WechatConfig::whereAppId($wechatAppid)->first();
        $wechat->authCode = $event->getAuthorizationCode();
        $wechat->authCodeExpiresIn = Carbon::createFromTimestamp($event->getAuthorizationCodeExpiredTime());
        $wechat->authInfoType = $event->getInfoType();
        $wechat->save();
    }
}
