<?php

namespace App\Events;

use App\Entities\Order;
use App\Repositories\ShopRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPaidNoticeEvent extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    protected $shopId = null;
    protected $shopOrderInfo = null;
    protected $voiceText = null;
    /**
     * Create a new event instance.
     * @param int $shopId
     * @param Order $order
     * @return void
     */
    public function __construct(int $shopId, Order $order)
    {
        //
        $this->shopId = $shopId;
        $this->voiceText = $order->payType === Order::ALI_PAY ? "支付宝收款{$order->paymentAmount}元"
            : "微信收款{$order->paymentAmount}元";

        $this->shopOrderInfo = app(ShopRepository::class)->todayOrderInfo($shopId);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("shop-{$this->shopId}");
    }
}
