<?php

namespace App\Listeners;

use App\Entities\MemberCard;
use App\Events\MemberCardActiveEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberCardActiveEventListener
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
     * @param  MemberCardActiveEvent  $event
     * @return void
     */
    public function handle(MemberCardActiveEvent $event)
    {
        //
        $card = MemberCard::whereCardId($event->getCardId())
            ->whereCode($event->getUserCardCode())
            ->first();
        if($card) {
            with($card, function (MemberCard $card) use($event) {
                $card->active = true;
                $card->save();
            });
        }
    }
}
