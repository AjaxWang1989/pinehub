<?php
/**
 * OrderCreateEventListener.php
 * User: katherine
 * Date: 19-5-19 下午7:14
 */

namespace App\Listeners;

use App\Entities\RechargeableCard;
use App\Entities\UserRechargeableCardConsumeRecord;
use App\Events\OrderCreateEvent;
use App\Repositories\RechargeableCardRepository;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;

class OrderCreateEventListener
{
    public function __construct()
    {
    }

    public function handle(OrderCreateEvent $event)
    {
        $rechargeableCardRepository = app(RechargeableCardRepository::class);
        $consumeRepository = app(UserRechargeableCardConsumeRecordRepository::class);
        $order = $event->order;
        $merchandiseIds = $order->orderItems()->pluck('merchandise_id');
        $rechargeableCards = $rechargeableCardRepository->findWhereIn('merchandise_id', $merchandiseIds->toArray());
        if (count($rechargeableCards) === 0) {
            return;
        }

        /** @var RechargeableCard $rechargeableCard */
        foreach ($rechargeableCards as $rechargeableCard) {
            $consumeData = [
                'customer_id' => $order->customerId,
                'user_id' => $order->memberId,
                'order_id' => $order->id,
                'rechargeable_card_id' => $rechargeableCard->id,
                'type' => UserRechargeableCardConsumeRecord::TYPE_BUY,
            ];
            $consumeRepository->create($consumeData);
        }
    }
}