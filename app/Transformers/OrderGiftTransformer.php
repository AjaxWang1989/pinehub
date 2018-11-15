<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Activity;

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
     * @param \App\Entities\Activity $model
     *
     * @return array
     */
    public function transform( Activity $model)
    {
        return [
            'id'         => (int) $model->id,
            'title'      => $model->title,
            'start_at'   => $model->startAt,
            'end_at'     => $model->endAt,
            'status'     => $model->status,
            'type'       => $model->type,
            'gifts' => $model->paymentActivities,
        ];
    }
}
