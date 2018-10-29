<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\PaymentActivity;

/**
 * Class OrderGiftTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderGiftTransformer extends TransformerAbstract
{
    /**
     * Transform the PaymentActivity entity.
     * )*
     * @param \App\Entities\PaymentActivity $model
     *
     * @return array
     */
    public function transform( PaymentActivity $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'activity_id' => $model->activityId,
            'ticket_id' => $model->typticketId,
            'discount' => $model->discount,
            'cost' => $model->cost,
            'least_amount' => $model->least_amount,
            'score' => $model->score,
            'type' => $model->type,
        ];
    }
}
