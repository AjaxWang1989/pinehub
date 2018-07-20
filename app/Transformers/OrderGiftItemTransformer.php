<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OrderGift as OrderGiftItem;

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
     * @param OrderGiftItem $model
     *
     * @return array
     */
    public function transform(OrderGiftItem $model)
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
