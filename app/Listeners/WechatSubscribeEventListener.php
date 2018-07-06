<?php

namespace App\Listeners;

use App\Events\WechatSubscribeEvent;

class WechatSubscribeEventListener
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
     * @param  WechatSubscribeEvent  $event
     * @return void
     * @throws
     */
    public function handle(WechatSubscribeEvent $event)
    {
        //
        $cardId = null;
        app('wechat')->openPlatform()->officialAccount($event->getAuthorizerAppid())->broadcasting->sendCard($cardId, $event->getOpenId());
    }
}
