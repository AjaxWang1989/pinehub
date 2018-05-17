<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\County;

/**
 * Class CountiesItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountiesItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CountiesItem entity.
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
            'country' => $model->country->only(['id', 'code', 'name']),
            'province' => $model->province->only(['id', 'code', 'name']),
            'city' => $model->only(['id', 'code', 'name']),
            'code' => $model->code,
            'name' => $model->name,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
