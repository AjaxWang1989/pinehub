<?php

namespace App\Listeners;

use App\Events\UserEnterOfficialAccountFromCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEnterOfficialAccountFromCardEventListener
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
     * @param  UserEnterOfficialAccountFromCardEvent  $event
     * @return void
     */
    public function handle(UserEnterOfficialAccountFromCardEvent $event)
    {
        //
    }
}
