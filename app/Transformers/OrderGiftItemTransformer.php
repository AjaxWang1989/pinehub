<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OrderGiftItem;

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
     * @param \App\Entities\OrderGiftItem $model
     *
     * @return array
     */
    public function transform(OrderGiftItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
