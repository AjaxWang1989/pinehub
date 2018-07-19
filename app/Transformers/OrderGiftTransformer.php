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

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
