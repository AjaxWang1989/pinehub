<?php

namespace App\Listeners;

use App\Events\UserSendCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSendCardEventListener
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
     * @param  UserSendCardEvent  $event
     * @return void
     */
    public function handle(UserSendCardEvent $event)
    {
        //
    }
}
