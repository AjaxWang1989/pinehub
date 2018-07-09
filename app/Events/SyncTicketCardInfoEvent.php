<?php

namespace App\Events;

use App\Entities\Card;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SyncTicketCardInfoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $card = null;
    /**
     * Create a new event instance.
     * @param Card $card
     * @return void
     */
    public function __construct(Card $card)
    {
        //
        $this->card = $card;
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
