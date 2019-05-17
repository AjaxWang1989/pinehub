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


            'created_at' => (string)$model->createdAt,
            'updated_at' => (string)$model->updatedAt
        ];
    }
}
