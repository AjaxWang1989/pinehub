<?php

namespace App\Transformers;

use App\Entities\Province;
use League\Fractal\TransformerAbstract;
use App\Entities\Country;

/**
 * Class CountryDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountryDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the CountryDetail entity.
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
            'provinces' => $model->provinces->map(function (Province $province){
                return [
                    'id' => $province->id,
                    'code' => $province->code,
                    'name' => $province->name
                ];
            }),
            'cities_count' => $model->citiesCount,
            'provinces_count' => $model->provincesCount,
            'counties_count' => $model->countiesCount,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
