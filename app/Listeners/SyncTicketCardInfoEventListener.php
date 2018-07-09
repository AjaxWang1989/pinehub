<?php

namespace App\Listeners;

use App\Events\SyncTicketCardInfoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     */
    public function handle(SyncTicketCardInfoEvent $event)
    {
        //
        app('wechat')->card($event->card->cardType, $event->card->cardInfo);
    }
}
