<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatAutoReplyMessageItem;

/**
 * Class WechatAutoReplyMessageItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatAutoReplyMessageItemTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatAutoReplyMessageItem entity.
     *
     * @param \App\Entities\WechatAutoReplyMessageItem $model
     *
     * @return array
     */
    public function transform(WechatAutoReplyMessageItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
