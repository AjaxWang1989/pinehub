<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\StoreDetail;

/**
 * Class StoreDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class StoreDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the StoreDetail entity.
     *
     * @param \App\Entities\StoreDetail $model
     *
     * @return array
     */
    public function transform(StoreDetail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
