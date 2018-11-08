<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Events\SyncMemberCardInfoEvent;
use Illuminate\Support\Facades\Log;

class SyncMemberCardInfoEventListener
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
     * @throws
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

        if($memberCard->sync === Card::SYNC_ING) {
            sleep(10);
        }
        $memberInfo = $event->memberInfo;
        $memberInfo['discount'] *= 10;
        $memberInfo['auto_activate'] = (boolean)$memberInfo['auto_activate'];
        $memberInfo['base_info']['can_share'] = (boolean)$memberInfo['base_info']['can_share'];

        Log::info('member card info ', $memberInfo);
        if($memberCard->cardId === null) {
            $result = $event->wechat->card->create($memberCard->cardType, $memberInfo);
        } else {
            $result = $event->wechat->card->update($memberCard->cardId, $memberCard->cardType, $memberInfo);
        }
        if($result['errcode'] === 0) {
            $app = $memberCard->app()->first();
            if(!$memberCard->cardId){
                $memberCard->cardId = $result['card_id'];
                $memberCard->wechatAppId = $app->wechatAppId;
            }
            $memberCard->sync = Card::SYNC_SUCCESS;
            $memberCard->save();
        } else {
            $memberCard->sync = Card::SYNC_FAILED;
            $memberCard->save();
            throw new \Exception(json_encode($result));
        }

    }
}
