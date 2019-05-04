<?php

namespace App\Listeners;

use App\Events\MemberScoreUpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberScoreUpdateEventListener
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
     * @param  MemberScoreUpdateEvent  $event
     * @return void
     */
    public function handle(MemberScoreUpdateEvent $event)
    {
        //
    }
}
