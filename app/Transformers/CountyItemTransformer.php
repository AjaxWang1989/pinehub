<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\County as CountyItem;

/**
 * Class CountyItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountyItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CountyItem entity.
     *
     * @param CountyItem $model
     *
     * @return array
     */
    public function transform(CountyItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'code'       => $model->code,
            'city'       => $model->city->name,
            'province'   => $model->province->name,
            'country'    => $model->country->name,
            /* place your other model properties here */
            'province_id' => $model->provinceId,
            'city_id' => $model->cityId,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
