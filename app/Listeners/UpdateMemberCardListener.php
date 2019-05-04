<?php

namespace App\Listeners;

use App\Entities\MemberCard;
use App\Events\UpdateMemberCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMemberCardListener
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
     * @param  UpdateMemberCardEvent  $event
     * @return void
     */
    public function handle(UpdateMemberCardEvent $event)
    {
        //
        $card = MemberCard::whereCardId($event->getCardId())
            ->whereCode($event->getUserCardCode())
            ->first();
        if($card) {
            with($card, function (MemberCard $card) use($event) {
                $card->bonus = $event->getBonus();
                $card->balance = $event->getBalance();
                $card->save();
            });
        }
    }
}
