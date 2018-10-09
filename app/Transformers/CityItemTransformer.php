<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\City as CityItem;

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
     * @param CityItem $model
     *
     * @return array
     */
    public function transform(CityItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'code'       => $model->code,
            'province'   => $model->province->name,
            'country'    => $model->country->name,
            'counties_count' => $model->countiesCount ? $model->countiesCount : 0,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
