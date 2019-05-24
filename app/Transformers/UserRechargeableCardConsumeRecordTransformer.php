<?php


namespace App\Transformers;

use App\Entities\UserRechargeableCardConsumeRecord;
use League\Fractal\TransformerAbstract;

class UserRechargeableCardConsumeRecordTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['rechargeableCard', 'user', 'order', 'userRechargeableCard'];

    public function transform(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        return [
            'id' => $consumeRecord->id,

            'user_id' => $consumeRecord->userId,
            'customer_id' => $consumeRecord->userId,
            'order_id' => $consumeRecord->orderId,
            'rechargeable_card_id' => $consumeRecord->rechargeableCardId,
            'user_rechargeable_card_id' => $consumeRecord->userRechargeableCardId,
            'type' => $consumeRecord->type,
            'type_desc' => $consumeRecord->typeDesc,
            'consume' => number_format($consumeRecord->consume / 100, 2),
            'save' => number_format($consumeRecord->save / 100, 2),
            'channel' => $consumeRecord->channel,
            'channel_desc' => $consumeRecord->channelDesc,

            'created_at' => (string)$consumeRecord->createdAt,
            'updated_at' => (string)$consumeRecord->updatedAt
        ];
    }

    public function includeRechargeableCard(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $rechargeableCard = $consumeRecord->rechargeableCard;

        return $this->item($rechargeableCard, new RechargeableCardTransformer);
    }

    public function includeUser(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $user = $consumeRecord->user;

        return $user ? $this->item($user, new UserSimplifyTransformer) : null;
    }

    public function includeOrder(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $order = $consumeRecord->order;

        return $order ? $this->item($order, new OrderTransformer) : null;
    }

    public function includeUserRechargeableCard(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $userRechargeableCard = $consumeRecord->userRechargeableCard;

        return $this->item($userRechargeableCard, new UserRechargeableCardTransformer);
    }
}