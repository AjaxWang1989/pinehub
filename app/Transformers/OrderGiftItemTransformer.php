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
            'order_count' => $model->orderCount,
            'customer_count' => $model->customerCount,
            'money'      =>    $model->orders->sum('total_amount')
        ];
    }
}
