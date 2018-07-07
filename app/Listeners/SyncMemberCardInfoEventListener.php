<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Entities\WechatConfig;
use App\Events\SyncMemberCardInfoEvent;
use Carbon\Carbon;

class SyncMemberCardInfoEventListener extends AsyncEventListener
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
     * @param  SyncMemberCardInfoEvent  $event
     * @return void
     */
    public function handle(SyncMemberCardInfoEvent $event)
    {
        //
        $memberCard = $event->memberCard;
        if(!$memberCard->wechatAppId) {
            $memberCard = Card::with('app')->find($memberCard->id);
            $memberCard->wechatAppId = $memberCard->app->wechatAppId;
            $memberCard->save();
        }
        if(!$memberCard->wechatAppId) {
            $this->fail();
            if($this->attempts() > 10)
                $this->delete();
        }
        $wechat = WechatConfig::where('app_id', $memberCard->wechatAppId)->first();
        tap($wechat, function (WechatConfig $config) {
            $now = Carbon::now();
            if($config->authorizerAccessTokenExpiresIn->getTimestamp() < $now->getTimestamp()) {
                if($config->componentAccessTokenExpiresIn->getTimestamp() < $now->getTimestamp()) {
                    app('wechat')->openPlatform()->access_token->getToken(true);
                }
                app('wechat')->openPlatform()->officialAccount($config->appId, $config->authorizerRefreshToken)->access_token->getToken(true);
            }
        });
        if($memberCard->sync === Card::SYNC_ING) {
            sleep(10);
        }

        if($memberCard->cardId === null) {
            $result = app('wechat')->openPlatform()->officialAccount($memberCard->wechatAppId)->card
                ->create($memberCard->cardType, $memberCard->cardInfo);
        } else {
            $result = app('wechat')->openPlatform()->officialAccount($memberCard->wechatAppId)->card
                ->update($memberCard->cardId, $memberCard->cardType, $memberCard->cardInfo);
        }

        if($result['errcode'] === 0) {
            $app = $memberCard->app()->first();
            $memberCard->cardId = $result['card_id'];
            $memberCard->wechatAppId = $app->wechatAppId;
            $memberCard->sync = Card::SYNC_SUCCESS;
        } else {
          $memberCard->sync = Card::SYNC_FAILED;
        }
        $memberCard->save();
    }
}
