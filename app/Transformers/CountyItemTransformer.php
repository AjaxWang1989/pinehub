<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CountyItem;

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
     * @param \App\Entities\CountyItem $model
     *
     * @return array
     */
    public function transform(CountyItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
