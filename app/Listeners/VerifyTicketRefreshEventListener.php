<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Events\OpenPlatform\VerifyTicketRefreshed;

class VerifyTicketRefreshEventListener
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
     * @param  VerifyTicketRefreshed  $event
     * @return void
     */
    public function handle(VerifyTicketRefreshed $event)
    {
        //
        $app = app('wechat')->openPlatform();
        Log::debug('new listener');
        tap($app['verify_ticket'], function (VerifyTicket $ticket) use($event){
            $ticket->setTicket($event->getComponentVerifyTicket());
        });
    }
}
