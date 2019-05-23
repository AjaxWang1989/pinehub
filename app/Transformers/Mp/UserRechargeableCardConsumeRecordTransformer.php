<?php
/**
 * UserRechargeableCardConsumeRecordTransformer.php
 * User: katherine
 * Date: 19-5-20 下午11:52
 */

namespace App\Transformers\Mp;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Transformers\OrderTransformer;
use League\Fractal\TransformerAbstract;

class UserRechargeableCardConsumeRecordTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'rechargeableCard',
        'userRechargeableCard',
        'order'
    ];

    public function transform(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        return [
            'id' => $consumeRecord,
            'type_desc' => $consumeRecord->typeDesc,
            'type' => $consumeRecord->type,
            'consume' => UserRechargeableCardConsumeRecord::SIGNS[$consumeRecord->type] . number_format($consumeRecord->consume / 100, 2),// 单位：元
            'save' => number_format($consumeRecord->save * 100, 2),
            'created_at' => (string)$consumeRecord->createdAt
        ];
    }

    public function includeRechargeableCard(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $rechargeableCard = $consumeRecord->rechargeableCard;

        return $rechargeableCard ? $this->item($rechargeableCard, new RechargeableCardTransformer) : null;
    }

    public function includeUserRechargeableCard(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $userRechargeableCard = $consumeRecord->userRechargeableCard;

        return $userRechargeableCard ? $this->item($userRechargeableCard, new UserRechargeableCardTransformer) : null;
    }

    public function includeOrder(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $order = $consumeRecord->order;

        return $order ? $this->item($order, new OrderTransformer) : null;
    }
}