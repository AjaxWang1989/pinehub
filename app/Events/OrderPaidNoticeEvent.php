<?php

namespace App\Events;

use App\Entities\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPaidNoticeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $userId = null;
    protected $shopId = null;
    protected $shopOrderInfo = null;
    protected $voiceText = null;
    /**
     * Create a new event instance.
     * @param int $userId
     * @param int $shopId
     * @param Order $order
     * @return void
     */
    public function __construct(int $userId, int $shopId, Order $order)
    {
        //
        $this->userId = $userId;
        $this->shopId = $shopId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("shop-{$this->shopId}-user-{$this->userId}");
    }
}
