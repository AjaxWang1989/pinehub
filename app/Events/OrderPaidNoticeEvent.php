<?php

namespace App\Events;

use App\Entities\Order;
use App\Repositories\ShopRepository;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class OrderPaidNoticeEvent extends Event implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets;

    protected $shopId = null;
    protected $voiceText = null;
    /**
     * Create a new event instance.
     * @param int $shopId
     * @param Order $order
     * @return void
     */
    public function __construct(int $shopId, Order $order = null)
    {
        //
        $this->shopId = $shopId;
        $this->voiceText = $order->payType === Order::ALI_PAY ? "支付宝收款{$order->paymentAmount}元"
            : "微信收款{$order->paymentAmount}元";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|null
     * @throws \Exception
     */
    public function broadcastOn()
    {
        Log::info("shop-{$this->shopId}-registerId");
        return cache("shop-{$this->shopId}-registerId", null);
    }

    public function broadcastWith()
    {
        return [$this->voiceText];
    }
}
