<?php

namespace App\Listeners;

use App\Entities\WechatConfig;
use App\Events\SyncTicketCardInfoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncTicketCardInfoEventListener
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
     * @param  SyncTicketCardInfoEvent  $event
     * @return void
     */
    public function handle(SyncTicketCardInfoEvent $event)
    {
        //
        $ticket = $event->card;
        if(!$ticket->wechatAppId) {
            $ticket = Card::with('app')->find($ticket->id);
            $ticket->wechatAppId = $ticket->app->wechatAppId;
            $ticket->save();
        }
        if(!$ticket->wechatAppId) {
            $this->fail();
            if($this->attempts() > 10)
                $this->delete();
        }
        /** @var WechatConfig $wechat */
        $wechat = WechatConfig::where('app_id', $ticket->wechatAppId)->first();
        if($ticket->sync === Card::SYNC_ING) {
            sleep(10);
        }

        if($ticket->cardId === null) {
            $result = app('wechat')->openPlatform()->officialAccount($ticket->wechatAppId, $wechat->authorizerRefreshToken)->card
                ->create($ticket->cardType, $ticket->cardInfo);
        } else {
            $result = app('wechat')->openPlatform()->officialAccount($ticket->wechatAppId, $wechat->authorizerRefreshToken)->card
                ->update($ticket->cardId, $ticket->cardType, $ticket->cardInfo);
        }

        if($result['errcode'] === 0) {
            $app = $ticket->app()->first();
            $ticket->cardId = $result['card_id'];
            $ticket->wechatAppId = $app->wechatAppId;
            $ticket->sync = Card::SYNC_SUCCESS;
        } else {
            $ticket->sync = Card::SYNC_FAILED;
        }
        $ticket->save();
    }
}
