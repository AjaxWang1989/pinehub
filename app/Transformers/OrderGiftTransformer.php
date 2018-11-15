<?php

namespace App\Transformers;

use App\Entities\PaymentActivity;
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
        $gifts = $model->paymentActivities;
        $gifts = $gifts->map(function (PaymentActivity $activity) {
            $types = [];
            if($activity->score) {
                array_push($types, 'score');
            }

            if($activity->discount) {
                array_push($types, 'discount');
            }

            if($activity->cost) {
                array_push($types, 'cost');
            }

            if($activity->ticketId) {
                array_push($types, 'ticket_id');
            }
            $activity['gift_types'] = $types;
            return $activity;
        });
        return [
            'id'         => (int) $model->id,
            'title'      => $model->title,
            'start_at'   => $model->startAt->format('Y-m-d H:i:s'),
            'end_at'     => $model->endAt->format('Y-m-d H:i:s'),
            'status'     => $model->status,
            'type'       => $model->type,
            'gifts' => $gifts,
        ];
    }
}
