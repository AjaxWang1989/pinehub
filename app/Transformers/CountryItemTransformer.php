<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Country as CountryItem;

/**
 * Class CountryItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountryItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CountryItem entity.
     *
     * @param CountryItem $model
     *
     * @return array
     */
    public function transform(CountryItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'code'       => $model->code,
            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
