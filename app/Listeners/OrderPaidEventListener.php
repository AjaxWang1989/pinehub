<?php
/**
 * OrderCreateEventListener.php
 * User: katherine
 * Date: 19-5-19 下午6:12
 */

namespace App\Listeners;


use App\Entities\RechargeableCard;
use App\Entities\UserRechargeableCard;
use App\Events\OrderPaidEvent;
use App\Repositories\RechargeableCardRepository;
use App\Repositories\UserRechargeableCardRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderPaidEventListener
{
    public function __construct()
    {
    }

    public function handle(OrderPaidEvent $event,
                           RechargeableCardRepository $rechargeableCardRepository,
                           UserRechargeableCardRepository $userRechargeableCardRepository)
    {
        $order = $event->order;
        $merchandiseIds = $order->orderItems()->pluck('merchandise_id');
        $rechargeableCards = $rechargeableCardRepository->findWhereIn('merchandise_id', $merchandiseIds->toArray());
        Log::info('订单中卡种数量为：' . count($rechargeableCards));
        if (count($rechargeableCards) <= 0) {
            return;
        }
        /**
         * 添加用户持有卡片记录
         */
        /** @var RechargeableCard $rechargeableCard */
        foreach ($rechargeableCards as $rechargeableCard) {
            $userRechargeableCardData = [
                'customer_id' => $order->customerId,
                'user_id' => $order->memberId,
                'rechargeable_card_id' => $rechargeableCard->id,
                'order_id' => $order->id,
                'amount' => $rechargeableCard->amount,
                'valid_at' => Carbon::now(),
                'invalid_at' => $rechargeableCard->type === RechargeableCard::TYPE_INDEFINITE ?
                    null : Carbon::now()->{'add' . ucfirst($rechargeableCard->unit)}($rechargeableCard->count),
                'is_auto_renew' => false,
                'status' => UserRechargeableCard::STATUS_VALID,
            ];
            $userRechargeableCardRepository->create($userRechargeableCardData);
        }
    }
}