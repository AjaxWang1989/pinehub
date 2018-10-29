<?php

namespace App\Transformers;

use App\Repositories\OrderRepository;
use League\Fractal\TransformerAbstract;
use App\Entities\Activity;

/**
 * Class OrderGiftItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderGiftItemTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderGiftItem entity.
     *
     * @param Activity $model
     *
     * @return array
     */
    public function transform(Activity $model)
    {
        return [
            'id'         => (int) $model->id,
            'title'       => $model->title,
            'start_at'   => $model->startAt,
            'end_at'     => $model->endAt,
            'status'     => $model->status,
            'order_count' => $model->order_count,
            'customer_count' => $model->customer_count,
            'money'      =>$model->orders->sum('total_amount')
        ];
    }
}
