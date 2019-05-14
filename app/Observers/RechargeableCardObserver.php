<?php
/**
 * RechargeableCardObserver.php
 * User: katherine
 * Date: 19-5-14 下午3:12
 */

namespace App\Observers;

use App\Entities\RechargeableCard;

class RechargeableCardObserver
{
    public function creating(RechargeableCard $rechargeableCard)
    {
        $rechargeableCard->status = $rechargeableCard->status ?? RechargeableCard::STATUS_DEFINED_ONLY;
        // 金额单位：分
        $rechargeableCard->amount = $rechargeableCard->amount * 100 ?? 0;
        $rechargeableCard->price = $rechargeableCard->price * 100;
        $rechargeableCard->preferentialPrice = $rechargeableCard->preferentialPrice * 100;
        $rechargeableCard->autoRenewPrice = $rechargeableCard->autoRenewPrice * 100;
    }
}