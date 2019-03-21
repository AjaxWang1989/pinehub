<?php

namespace App\Listeners;

use App\Events\UserViewCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserViewMemberCardEventListener
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
     * @param  UserViewCardEvent  $event
     * @return void
     */
    public function handle(UserViewCardEvent $event)
    {
        //
    }
}
