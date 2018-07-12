<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MerchandiseItem;

/**
 * Class MerchandiseItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class MerchandiseItemTransformer extends TransformerAbstract
{
    /**
     * Transform the MerchandiseItem entity.
     *
     * @param \App\Entities\MerchandiseItem $model
     *
     * @return array
     */
    public function transform(MerchandiseItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
