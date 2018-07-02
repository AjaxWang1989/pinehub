<?php

namespace App\Listeners;

use EasyWeChat\OpenPlatform\Auth\VerifyTicket;
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
        tap($app['verify_ticket'], function (VerifyTicket $ticket) use($event){
            $ticket->setTicket($event->getComponentVerifyTicket());
        });
    }
}
