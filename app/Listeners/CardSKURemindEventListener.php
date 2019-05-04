<?php

namespace App\Listeners;

use App\Events\CardSKURemindEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CardSKURemindEventListener
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
     * @param  CardSKURemindEvent  $event
     * @return void
     */
    public function handle(CardSKURemindEvent $event)
    {
        //
    }
}
