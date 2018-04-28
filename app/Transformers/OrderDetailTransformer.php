<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Order as OrderDetail;

/**
 * Class OrderDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderDetail entity.
     *
     * @param OrderDetail $model
     *
     * @return array
     */
    public function transform(OrderDetail $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
