<?php

namespace App\Listeners;

use App\Entities\Ticket;
use App\Events\SyncTicketCardInfoEvent;
use Illuminate\Support\Facades\Log;

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
     * @throws
     */
    public function handle(SyncTicketCardInfoEvent $event)
    {
        //
        $ticket = $event->ticket;
        if(!$ticket->wechatAppId) {
            $ticket = Ticket::with('app')->find($ticket->id);
            $ticket->wechatAppId = $ticket->app->wechatAppId;
            $ticket->save();
        }

        if($ticket->sync === Ticket::SYNC_ING) {
            sleep(10);
        }
        Log::info('card info', [$event->ticketInfo]);
        $cardInfo = isset($event->ticketInfo) && $event->ticketInfo ? $event->ticketInfo : $ticket->cardInfo;
        if(isset($cardInfo['discount'])) {
            $cardInfo['discount'] = 100 - $cardInfo['discount'];
        }

        if(isset($cardInfo['reduce_cost'])) {
            $cardInfo['reduce_cost'] *= 100;
        }

        if(isset($cardInfo['least_cost'])) {
            $cardInfo['least_cost'] *= 100;
        }

        if(isset($cardInfo['advanced_info']['use_condition']) && isset($cardInfo['advanced_info']['use_condition']['least_cost'])) {
            $cardInfo['advanced_info']['use_condition']['least_cost'] = (int)$cardInfo['advanced_info']['use_condition']['least_cost'];
        }

        if(isset($cardInfo['base_info']['date_info']['begin_timestamp'])) {
            $cardInfo['base_info']['date_info']['begin_timestamp'] = (int)$cardInfo['base_info']['date_info']['begin_timestamp'];
        }

        if(isset($cardInfo['base_info']['date_info']['end_timestamp'])) {
            $cardInfo['base_info']['date_info']['end_timestamp'] = (int)$cardInfo['base_info']['date_info']['end_timestamp'];
        }

        if(isset($cardInfo['base_info']['date_info']['fixed_begin_term'])) {
            $cardInfo['base_info']['date_info']['fixed_begin_term'] = (int)$cardInfo['base_info']['date_info']['fixed_begin_term'];
        }

        if(isset($cardInfo['base_info']['date_info']['fixed_term'])) {
            $cardInfo['base_info']['date_info']['fixed_term'] = (int)$cardInfo['base_info']['date_info']['fixed_term'];
        }

        Log::info('card info', $cardInfo);

        if($ticket->cardId === null) {
            $result = $event->wechat->card->create($ticket->cardType, $cardInfo);
        } else {
            $result = $event->wechat->card->update($ticket->cardId, $ticket->cardType, $cardInfo);
        }

        if($result['errcode'] === 0) {
            $app = $ticket->app()->first();
            if(!$ticket->cardId) {
                $ticket->cardId = $result['card_id'];
                $ticket->wechatAppId = $app->wechatAppId;
            }

            $ticket->sync = Ticket::SYNC_SUCCESS;
            $ticket->save();
        } else {
            $ticket->sync = Ticket::SYNC_FAILED;
            $ticket->save();
            throw new \Exception($result['errmsg']);
        }

    }
}
