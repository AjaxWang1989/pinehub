<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatMaterial;

/**
 * Class WechatMaterialTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatMaterialTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatMaterial entity.
     *
     * @param \App\Entities\WechatMaterial $model
     *
     * @return array
     */
    public function transform(WechatMaterial $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
