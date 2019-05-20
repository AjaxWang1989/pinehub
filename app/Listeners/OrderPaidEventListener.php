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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class OrderPaidEventListener
{
    public function __construct()
    {
    }

    public function handle(OrderPaidEvent $event)
    {
        $rechargeableCardRepository = app(RechargeableCardRepository::class);
        $userRechargeableCardRepository = app(UserRechargeableCardRepository::class);
        $order = $event->order;
        $merchandiseIds = $order->orderItems()->pluck('merchandise_id');
        $rechargeableCards = $rechargeableCardRepository->findWhereIn('merchandise_id', $merchandiseIds->toArray());
        if (count($rechargeableCards) <= 0) {
            return;
        }

        /**
         * 添加用户持有卡片记录
         */
        /** @var RechargeableCard $rechargeableCard */
        foreach ($rechargeableCards as $rechargeableCard) {

            if ($rechargeableCard->type === RechargeableCard::TYPE_INDEFINITE) {
                $validAt = Carbon::now();
                $invalidAt = null;
            } else {
                /**
                 * 用户拥有的有效有限期卡记录
                 */
                $userCards = $userRechargeableCardRepository->orderBy('id', 'desc')
                    ->scopeQuery(function (Builder $query) use ($order) {
                        return $query->where(function (Builder $query) use ($order) {
                            $query->where('customer_id', $order->customerId)
                                ->where('user_id', $order->memberId)
                                ->whereHas('rechargeableCard', function ($query) {
                                    $query->where('type', '<>', RechargeableCard::TYPE_INDEFINITE);
                                })
                                ->where('status', '=', UserRechargeableCard::STATUS_VALID);
                        });
                    })->all();
                Log::info('用户持有的有效有限期卡记录：', [$userCards]);
                if (count($userCards) === 0) {
                    $validAt = Carbon::now();
                } else {
                    /** @var Carbon $originInvalidAt */
                    $originInvalidAt = $userCards[0]->invalidAt;
                    $validAt = $originInvalidAt->addDay();
                }
                $invalidAt = $validAt->{'add' . ucfirst($rechargeableCard->unit)}($rechargeableCard->count);
            }

            $userRechargeableCardData = [
                'customer_id' => $order->customerId,
                'user_id' => $order->memberId,
                'rechargeable_card_id' => $rechargeableCard->id,
                'order_id' => $order->id,
                'amount' => $rechargeableCard->amount,
                'valid_at' => $validAt,
                'invalid_at' => $invalidAt,
                'is_auto_renew' => false,
                'status' => UserRechargeableCard::STATUS_VALID,
            ];
            Log::info('用户新持有卡：', [$userRechargeableCardData]);
            $userRechargeableCardRepository->create($userRechargeableCardData);
        }
    }
}