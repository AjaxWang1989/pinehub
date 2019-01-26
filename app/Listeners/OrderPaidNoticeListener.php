<?php

namespace App\Listeners;

use App\Events\OrderPaidNoticeEvent;
use Carbon\Carbon;
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
     * @throws
     */
    public function handle(OrderPaidNoticeEvent $event)
    {
        $messages = $event->broadcastWith();
        $cacheMessages = cache($event->broadcastOn(), []);
        cache([$event->broadcastOn() => array_merge($cacheMessages, $messages)], Carbon::now()->addMinute(10));
    }
}
