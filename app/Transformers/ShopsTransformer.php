<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Shops;

/**
 * Class ShopsTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopsTransformer extends TransformerAbstract
{
    /**
     * Transform the Shops entity.
     *
     * @param \App\Entities\Shops $model
     *
     * @return array
     */
    public function transform(Shops $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
