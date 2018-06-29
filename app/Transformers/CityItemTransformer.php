<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CityItem;

/**
 * Class CityItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CityItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CityItem entity.
     *
     * @param \App\Entities\CityItem $model
     *
     * @return array
     */
    public function transform(CityItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
