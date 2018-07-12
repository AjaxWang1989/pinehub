<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Merchandise;

/**
 * Class MerchandiseTransformer.
 *
 * @package namespace App\Transformers;
 */
class MerchandiseTransformer extends TransformerAbstract
{
    /**
     * Transform the Merchandise entity.
     *
     * @param \App\Entities\Merchandise $model
     *
     * @return array
     */
    public function transform(Merchandise $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
