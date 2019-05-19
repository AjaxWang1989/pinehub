<?php
/**
 * UserRechargeableCardTransformer.php
 * User: katherine
 * Date: 19-5-17 下午5:35
 */

namespace App\Transformers\Mp;

use App\Entities\UserRechargeableCard;
use League\Fractal\TransformerAbstract;

class UserRechargeableCardTransformer extends TransformerAbstract
{
    public function transform(UserRechargeableCard $rechargeableCard)
    {
        return [
            'id' => $rechargeableCard->id,

            'user_id' => $rechargeableCard->userId,
            'order_id' => $rechargeableCard->orderId,
            'rechargeable_card_id' => $rechargeableCard->rechargeableCardId,
            'amount' => $rechargeableCard->amount,
            'valid_at' => (string)$rechargeableCard->validAt,
            'invalid_at' => (string)$rechargeableCard->invalidAt,
            'is_auto_renew' => (bool)$rechargeableCard->isAutoRenew,
            'status' => $rechargeableCard->status,
            'status_desc' => $rechargeableCard->statusDesc,

            'created_at' => (string)$rechargeableCard->createdAt,
            'updated_at' => (string)$rechargeableCard->updatedAt
        ];
    }
}