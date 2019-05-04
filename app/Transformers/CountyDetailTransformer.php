<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CountyDetail;

/**
 * Class CountyDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountyDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the CountyDetail entity.
     *
     * @param \App\Entities\CountyDetail $model
     *
     * @return array
     */
    public function transform(CountyDetail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
