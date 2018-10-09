<?php

namespace App\Listeners;

use App\Entities\ScoreRule;
use App\Events\OrderScoreEvent;
use Carbon\Carbon;

class OrderScoreListener extends AsyncEventListener
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
     * @param  OrderScoreEvent  $event
     * @return void
     */
    public function handle(OrderScoreEvent $event)
    {
        //
        ScoreRule::whereIn('type', [ScoreRule::ORDER_COUNT_RULE, ScoreRule::ORDER_COUNT_RULE])->where('expires_at', '<', Carbon::now())->chunk(100, function (ScoreRule $scoreRule) use($event){
            $scoreRule->orderScore($event->order);
        });
    }
}
