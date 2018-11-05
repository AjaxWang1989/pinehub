<?php

namespace App\Listeners;

use App\Entities\Customer;
use App\Entities\Order;
use App\Entities\OrderItem;
use App\Events\UserCardPaidEvent;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCardPaidListener
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
     * @param  UserCardPaidEvent  $event
     * @return void
     */
    public function handle(UserCardPaidEvent $event)
    {
        //
        $order = Order::whereTransactionId($event->getTransId())->first();
        if($order) {
            with($order, function (Order $order) use($event){
                $order->cardId = $event->getCardId();
                $order->cardCode = $event->getUserCardCode();
                $order->save();
            });
        }else{
            $customer = Customer::wherePlatformOpenId($event->getFromUserName())
                ->whereIn('type', [Customer::WECHAT_OFFICE_ACCOUNT, Customer::WECHAT_MINI_PROGRAM, Customer::WECHAT_OPEN_PLATFORM])
                ->first();
            $order = new Order();
            $order->cardId = $event->getCardId();
            $order->cardCode = $event->getUserCardCode();
            $order->type = Order::OFF_LINE_PAY;
            $order->appId = $customer->appId;
            $order->openId = $customer->platformOpenId;
            $order->wechatAppId = $customer->platformAppId;
            $order->payType = Order::WECHAT_PAY;
            $order->status = Order::COMPLETED;
            $order->memberId = $customer->memberId;
            $order->totalAmount = $event->getOriginalFee();
            $order->paymentAmount = $event->getFee();
            $order->paidAt = Carbon::createFromTimestamp($event->getCreateTime());
            $order->discountAmount = $event->getOriginalFee() - $event->getFee();
            $order->save();
            $orderItem = new OrderItem();
            $orderItem->discountAmount = $order->discountAmount;
            $orderItem->paymentAmount = $order->paymentAmount;
            $orderItem->totalAmount = $order->totalAmount;
            $orderItem->status = $order->status;
            $orderItem->paidAt = $order->paidAt;
            $orderItem->appId = $order->appId;
            $orderItem->memberId = $order->memberId;
            $orderItem->customerId = $order->customerId;
            $orderItem->quality = 1;
            $order->orderItems()->save($orderItem);
        }
    }
}
