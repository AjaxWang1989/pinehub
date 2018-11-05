<?php

namespace App\Listeners;

use App\Entities\CustomerTicketCard;
use App\Events\UserConsumeCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConsumeCardEventListener
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
     * @param  UserConsumeCardEvent  $event
     * @return void
     */
    public function handle(UserConsumeCardEvent $event)
    {
        //
        $ticket = CustomerTicketCard::whereOpenId($event->getFromUserName())
            ->whereCardId($event->getCardId())
            ->whereCode($event->getUserCardCode())
            ->first();
        if($ticket) {
            with($ticket, function (CustomerTicketCard $card) {
                $card->status = CustomerTicketCard::STATUS_USE;
                $card->save();
            });
        }
    }
}
