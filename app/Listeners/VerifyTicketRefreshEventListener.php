<?php

namespace App\Listeners;

use App\Events\Authorized;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  Authorized  $event
     * @return void
     */
    public function handle(Authorized $event)
    {
        //
    }
}
