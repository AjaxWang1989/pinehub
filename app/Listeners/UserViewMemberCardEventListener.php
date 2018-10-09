<?php

namespace App\Listeners;

use App\Events\UserViewMemberCardEvent;
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
     * @param  UserViewMemberCardEvent  $event
     * @return void
     */
    public function handle(UserViewMemberCardEvent $event)
    {
        //
    }
}
