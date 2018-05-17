<?php

namespace App\Transformers;

use App\Entities\City;
use League\Fractal\TransformerAbstract;
use App\Entities\Province;

/**
 * Class ProvinceDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProvinceDetailTransformer extends TransformerAbstract
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
            'cities' => $model->cities->map(function (City $city){
                return $city->only(['id', 'code', 'name']);
            }),
            'cities_count' => $model->citiesCount,
            'counties_count' => $model->countiesCount,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
