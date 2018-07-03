<?php

namespace App\Transformers;

use App\Entities\City;
use League\Fractal\TransformerAbstract;
use App\Entities\Province;

/**
 * Class ProvinceTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProvinceTransformer extends TransformerAbstract
{
    /**
     * Transform the ProvinceDetail entity.
     *
     * @param \App\Entities\Province $model
     *
     * @return array
     */
    public function transform(Province $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'country' => $model->country->only(['id', 'code', 'name']),
            'code' => $model->code,
            'name' => $model->name,
            'cities_count' => $model->citiesCount ? $model->citiesCount : 0,
            'counties_count' => $model->countiesCount ? $model->citiesCount : 0,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
