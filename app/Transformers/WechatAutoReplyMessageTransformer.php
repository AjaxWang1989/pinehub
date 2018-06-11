<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatAutoReplyMessage;

/**
 * Class WechatAutoReplyMessageTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatAutoReplyMessageTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatAutoReplyMessage entity.
     *
     * @param \App\Entities\WechatAutoReplyMessage $model
     *
     * @return array
     */
    public function transform(WechatAutoReplyMessage $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
