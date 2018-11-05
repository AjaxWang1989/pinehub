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
        $payload = $event->payload;
        if($payload) {
            $card = Card::whereCardId($payload['CardId'])->first();
            $status = strtoupper($payload['Event']);
            $card->status = Card::STATUS[$status];
            $card->save();
        }
    }
}
