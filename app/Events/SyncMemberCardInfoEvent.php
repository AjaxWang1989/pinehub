<?php

namespace App\Events;

use App\Entities\Card;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SyncMemberCardInfoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $memberCard = null;

    /**
     * Create a new event instance.
     * @param Card $card
     * @return void
     */
    public function __construct(Card $card)
    {
        //
        $this->memberCard = $card;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
