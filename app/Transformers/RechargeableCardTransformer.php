<?php
/**
 * RechargeableCardTransformer.php
 * User: katherine
 * Date: 19-5-14 上午9:44
 */

namespace App\Transformers;

use App\Entities\RechargeableCard;
use League\Fractal\TransformerAbstract;

class RechargeableCardTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'category'
    ];

    protected $availableIncludes = [
        'giftTickets'
    ];

    public function transform(RechargeableCard $rechargeableCard)
    {
        return [
            'id' => $rechargeableCard->id,// ID
            'name' => $rechargeableCard->name,
            'money_unit' => '分',
            'amount' => $rechargeableCard->amount,// 卡内金额
            'price' => $rechargeableCard->price,// 售价
            'preferential_price' => $rechargeableCard->preferentialPrice,// 优惠价格
            'auto_renew_price' => $rechargeableCard->autoRenewPrice,// 自动续费价格
            'on_sale' => $rechargeableCard->onSale,// 是否优惠
            'is_recommend' => $rechargeableCard->isRecommend,
            'discount' => $rechargeableCard->discount,// 卡内折扣
            'card_type' => $rechargeableCard->cardType,
            'card_type_desc' => $rechargeableCard->cardTypeDesc,
            'type' => $rechargeableCard->type,
            'type_desc' => $rechargeableCard->typeDesc,
            'time_unit' => $rechargeableCard->unit,
            'count' => $rechargeableCard->count,
            'usage_scenarios' => $rechargeableCard->usageScenarios,
            'usage_scenarios_desc' => $rechargeableCard->usageScenariosDesc,
            'specified_start' => $rechargeableCard->specifiedStart,
            'specified_end' => $rechargeableCard->specifiedEnd,
            'status' => $rechargeableCard->status,
            'status_desc' => $rechargeableCard->statusDesc,
            'sort' => $rechargeableCard->sort
        ];
    }

    // 附赠优惠券
    public function includeGiftTickets(RechargeableCard $rechargeableCard)
    {
        $giftTickets = $rechargeableCard->giftTickets;

        return $this->collection($giftTickets, new TicketItemTransformer);
    }

    // 产品类别
    public function includeCategory(RechargeableCard $rechargeableCard)
    {
        $category = $rechargeableCard->category;

        return $this->item($category, new CategoryTransformer);
    }
}