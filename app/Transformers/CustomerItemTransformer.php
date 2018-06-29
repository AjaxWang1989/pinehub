<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CustomerItem;

/**
 * Class CustomerItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CustomerItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CustomerItem entity.
     *
     * @param \App\Entities\CustomerItem $model
     *
     * @return array
     */
    public function transform(CustomerItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
