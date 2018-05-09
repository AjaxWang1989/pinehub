<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Order;

/**
 * Class OrdersTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrdersTransformer extends TransformerAbstract
{
    /**
     * Transform the Orders entity.
     *
     * @param \App\Entities\Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
