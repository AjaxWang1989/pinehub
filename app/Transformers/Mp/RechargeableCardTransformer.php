<?php
/**
 * RechargeableCardTransformer.php
 * User: katherine
 * Date: 19-5-17 下午1:46
 */

namespace App\Transformers\Mp;

use App\Entities\RechargeableCard;
use League\Fractal\TransformerAbstract;

class RechargeableCardTransformer extends TransformerAbstract
{
    public function transform(RechargeableCard $rechargeableCard)
    {
        return [
            'id' => $rechargeableCard->id,
            'name' => $rechargeableCard->name,
            'price' => $rechargeableCard->price,
            'amount' => $rechargeableCard->amount,
            'on_sale' => $rechargeableCard->onSale,
            'preferential_price' => $rechargeableCard->preferentialPrice,
            'auto_renew_price' => $rechargeableCard->autoRenewPrice,
            'card_type_desc' => $rechargeableCard->cardTypeDesc,
            'type_desc' => $rechargeableCard->typeDesc,
            'discount' => $rechargeableCard->discount,
            'usage_scenarios_desc' => $rechargeableCard->usageScenariosDesc
        ];
    }
}