<?php

namespace App\Transformers;

use App\Entities\UserRechargeableCard;
use League\Fractal\TransformerAbstract;

/**
 * Class UserRechargeableCardTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserRechargeableCardTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'rechargeableCard'
    ];

    /**
     * Transform the UserRechargeableCard entity.
     *
     * @param UserRechargeableCard $model
     *
     * @return array
     */
    public function transform(UserRechargeableCard $model)
    {
        return [
            'id' => (int)$model->id,

            'user_id' => $model->userId,
            'customer_id' => $model->customerId,
            'order_id' => $model->orderId,
            'amount' => number_format($model->amount / 100, 2),
            'valid_at' => (string)$model->validAt,
            'invalid_at' => (string)$model->invalidAt,
            'is_auto_renew' => $model->isAutoRenew,
            'status' => $model->status,
            'status_desc' => $model->statusDesc,

            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt
        ];
    }

    public function includeRechargeableCard(UserRechargeableCard $userRechargeableCard)
    {
        $rechargeableCard = $userRechargeableCard->rechargeableCard;

        return $this->item($rechargeableCard, new RechargeableCardTransformer);
    }
}
