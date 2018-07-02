<?php

namespace App\Listeners;

use App\Events\UserUseCardToPayEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUseCardToPayEventListener
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
     * @param  UserUseCardToPayEvent  $event
     * @return void
     */
    public function handle(UserUseCardToPayEvent $event)
    {
        //
    }
}
