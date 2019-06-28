<?php

namespace App\Events\Socket;

use App\Entities\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class PaidNoticeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    /**
     * @var Order $order
     * */
    protected $order = null;

    /**
     * @var string $voice
     * */
    protected $voice = '';

    /**
     * Create a new event instance.
     *
     * @param Order $order
     * @param string $voice
     */
    public function __construct(Order $order, string $voice)
    {
        //
        $this->order = $order;
        $this->voice = $voice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('paid-notice-'.$this->order->shopId);
    }

}
