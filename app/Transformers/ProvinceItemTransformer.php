<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Province;

/**
 * Class ProvincesItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProvinceItemTransformer extends TransformerAbstract
{
    /**
     * Transform the ProvincesItem entity.
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
            'code' => $model->code,
            'name' => $model->name,
            'country' => $model->country->only(['id', 'code', 'name']),
            'counties_count' => $model->countiesCount,
            'cities_count' => $model->citiesCount,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
