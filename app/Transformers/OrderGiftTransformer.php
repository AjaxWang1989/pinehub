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
     *
     * @param \App\Entities\OrderGift $model
     *
     * @return array
     */
    public function transform(OrderGift $model)
    {
        return [
            'id'         => (int) $model->id,
            'app_id' => $model->appId,
            /* place your other model properties here */
            'name' => $model->name,
            'type' => $model->type,
            'status' => $model->status,
            'begin_at' => $model->beginAt,
            'end_at' => $model->endAt,
            'gift' => $model->gift,
            'tickets' => $model->tickets,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
