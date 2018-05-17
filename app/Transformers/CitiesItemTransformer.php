<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\City;

/**
 * Class CitiesItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CitiesItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CitiesItem entity.
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
            'code' => $model->code,
            'name' => $model->name,
            'counties_count' => $model->countiesCount,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
