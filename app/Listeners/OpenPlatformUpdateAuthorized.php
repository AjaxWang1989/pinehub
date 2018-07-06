<?php

namespace App\Listeners;

use App\Entities\WechatConfig;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use Overtrue\LaravelWeChat\Events\OpenPlatform\Authorized;
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
        try{
            $wechat = WechatConfig::whereAppId($wechatAppid)->first();
            $wechat->authCode = $event->getAuthorizationCode();
            $wechat->authCodeExpiresIn = Carbon::createFromTimestamp($event->getAuthorizationCodeExpiredTime());
            $wechat->authInfoType = $event->getInfoType();
            $wechat->save();
        }catch (\Exception $exception) {
            if($exception instanceof ModelNotFoundException) {
                Event::fire(new Authorized($event->payload));
            }
        }

    }
}
