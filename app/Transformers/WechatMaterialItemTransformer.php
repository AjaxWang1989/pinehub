<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatMaterialItem;

/**
 * Class WechatMaterialItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatMaterialItemTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatMaterialItem entity.
     *
     * @param \App\Entities\WechatMaterialItem $model
     *
     * @return array
     */
    public function transform(WechatMaterialItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
