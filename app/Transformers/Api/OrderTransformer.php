<?php

namespace App\Transformers\Api;

use League\Fractal\TransformerAbstract;
use App\Entities\Order;

/**
 * Class OrderTransformer.
 *
 * @package namespace App\Transformers\Api;
 */
class OrderTransformer extends TransformerAbstract
{
    /**
     * Transform the Order entity.
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
        ];
    }
}
