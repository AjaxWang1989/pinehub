<?php

namespace App\Transformers;

use App\Entities\County;
use League\Fractal\TransformerAbstract;
use App\Entities\City;

/**
 * Class CityTransformer.
 *
 * @package namespace App\Transformers;
 */
class CityTransformer extends TransformerAbstract
{
    /**
     * Transform the City entity.
     *
     * @param \App\Entities\City $model
     *
     * @return array
     */
    public function transform(City $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'country' => $model->country->only(['id', 'code', 'name']),
            'province' => $model->province->only(['id', 'code', 'name']),
            'counties_count' => $model->countiesCount ? $model->countiesCount : 0,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
