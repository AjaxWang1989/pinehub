<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\County;

/**
 * Class CountyTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountyTransformer extends TransformerAbstract
{
    /**
     * Transform the County entity.
     *
     * @param \App\Entities\County $model
     *
     * @return array
     */
    public function transform(County $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
