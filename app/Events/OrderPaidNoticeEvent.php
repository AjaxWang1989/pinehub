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
    public  const CACHE_KEY = 'payment-notice-voice-shop-';
    public $orderId = null;
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
        $this->orderId = $order->id;
        switch ($order->payType) {
            case Order::ALI_PAY: {
                if($order->type !== Order::CHARGE_BALANCE) {
                    $this->voiceText = "支付宝收款{$order->paymentAmount}元";
                }
                break;
            }
            case Order::WECHAT_PAY: {
                if($order->type !== Order::CHARGE_BALANCE) {
                    $this->voiceText = "微信收款{$order->paymentAmount}元";
                }
                break;
            }
            case Order::BALANCE_PAY: {
                $this->voiceText = "快乐松收款{$order->paymentAmount}元";
                break;
            }
        }

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

    public function noticeVoiceCacheKey($key = "")
    {

        try{
            Log::debug('---------noticeVoiceCacheKey-----------'.self::noticeVoiceCacheKey($this->shopId).$key);
            return self::noticeVoiceCacheKey($this->shopId).$key;
        }catch (\Exception $exception) {
            Log::debug('---------noticeVoiceCacheKey-----------', [$exception->getMessage()]);
           return null;
        }

    }


    public static function noticeVoiceKeyPrefix($id)
    {
        return self::CACHE_KEY.$id.'-';
    }

    public function broadcastWith()
    {
        return [$this->voiceText];
    }
}
