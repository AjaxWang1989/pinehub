<?php

namespace App\Listeners;

use App\Entities\CustomerTicketCard;
use App\Events\UserDelCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDelCardEventListener
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
     * @param  UserDelCardEvent  $event
     * @return void
     */
    public function handle(UserDelCardEvent $event)
    {
        //

        $ticket = CustomerTicketCard::whereOpenId($event->getFromUserName())
            ->whereCardId($event->getCardId())
            ->whereCode($event->getUserCardCode())
            ->first();
        if($ticket) {
            with($ticket, function (CustomerTicketCard $card) {
                $card->delete();
            });
        }
    }
}
