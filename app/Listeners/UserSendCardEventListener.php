<?php

namespace App\Listeners;

use App\Entities\CustomerTicketCard;
use App\Events\UserSendCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSendCardEventListener
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
     * @param  UserSendCardEvent  $event
     * @return void
     */
    public function handle(UserSendCardEvent $event)
    {
        //
        $ticket = CustomerTicketCard::whereOpenId($event->getFromUserName())
            ->whereCardId($event->getCardId())
            ->whereCode($event->getUserCardCode())
            ->first();

        if($ticket) {
            with($ticket, function (CustomerTicketCard $card) use($event){
                if($event->getIsReturnBack()) {
                    $card->status = CustomerTicketCard::STATUS_ON;
                    $card->active = true;
                }else{
                    $card->status = CustomerTicketCard::STATUS_SEND_FRIEND;
                    $card->friendOpenId = $event->getToUserName();
                    $card->active = false;
                }
                $card->save();
            });
        }
    }
}
