<?php

namespace App\Events;

use App\Entities\MpUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MpUserCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $mpUser = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MpUser $mpUser)
    {
        //
        $this->mpUser = $mpUser;
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
