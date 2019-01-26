<?php

namespace App\Listeners;

use App\Events\OrderPaidNoticeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPaidNoticeListener
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
     * @param  OrderPaidNoticeEvent  $event
     * @return void
     */
    public function handle(OrderPaidNoticeEvent $event)
    {
        //
        publish($event->broadcastOn(), 'OrderPaidNoticeEvent', $event->broadcastWith());
    }
}
