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

        return $this->item($user, new UserDetailTransformer);
    }

    public function includeOrder(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $order = $consumeRecord->order;

        return $this->item($order, new OrderTransformer);
    }

    public function includeUserRechargeableCard(UserRechargeableCardConsumeRecord $consumeRecord)
    {
        $userRechargeableCard = $consumeRecord->userRechargeableCard;

        return $this->item($userRechargeableCard, new UserRechargeableCardTransformer);
    }
}