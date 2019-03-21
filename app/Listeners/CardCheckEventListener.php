<?php

namespace App\Listeners;

use App\Entities\Card;
use App\Events\CardCheckEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        Log::info('check pass');
        //
        if($event->getCardId() && $event->getEvent()) {
            $card = Card::whereCardId($event->getCardId())->first();
            $status = strtoupper($event->getEvent());
            $card->syncStatus = Card::SYNC_STATUS[$status];
            $card->save();
        }
    }
}
