<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Events\CardCheckEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CardCheckEventListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CardCheckEvent  $event
     * @return void
     */
    public function handle(CardCheckEvent $event)
    {
        //
        if($event->getCardId() && $event->getEvent()) {
            $card = Card::whereCardId($event->getCardId())->first();
            $status = strtoupper($event->getEvent());
            $card->status = Card::STATUS[$status];
            $card->save();
        }
    }
}
