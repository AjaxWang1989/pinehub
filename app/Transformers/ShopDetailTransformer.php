<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ShopDetail;

/**
 * Class ShopDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class ShopDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the ShopDetail entity.
     *
     * @param \App\Entities\ShopDetail $model
     *
     * @return array
     */
    public function transform(ShopDetail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
