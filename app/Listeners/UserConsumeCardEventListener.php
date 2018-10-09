<?php

namespace App\Listeners;

use App\Events\UserConsumeCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConsumeCardEventListener
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
     * @param  UserConsumeCardEvent  $event
     * @return void
     */
    public function handle(UserConsumeCardEvent $event)
    {
        //
    }
}
