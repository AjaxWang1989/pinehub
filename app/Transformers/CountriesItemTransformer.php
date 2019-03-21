<?php

namespace App\Transformers;

use App\Entities\Country;
use League\Fractal\TransformerAbstract;

/**
 * Class CountriesItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountriesItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CountriesItem entity.
     *
     * @param \App\Entities\Country $model
     *
     * @return array
     */
    public function transform(Country $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'code' => $model->code,
            'name' => $model->name,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
