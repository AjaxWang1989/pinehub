<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OrderGift;

/**
 * Class OrderGiftTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderGiftTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderGift entity.
     )*
     * @param \App\Entities\OrderGift $model
     *
     * @return array
     */
    public function transform(OrderGift $model)
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
