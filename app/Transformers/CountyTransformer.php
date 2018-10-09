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
            'id'         => $model->id,
            'name'       => $model->name,
            'code'       => $model->code,
            'city'       => $model->city->only(['id', 'code', 'name']),
            'province'   => $model->province->only(['id', 'code', 'name']),
            'country'    => $model->country->only(['id', 'code', 'name']),
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
