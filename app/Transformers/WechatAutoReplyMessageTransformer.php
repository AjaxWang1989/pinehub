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
            'app_id' => $model->appId,
            'type' => $model->type,
            'focus_reply' => $model->focusReply,
            'prefect_match_keywords' => $model->prefectMatchKeywords,
            'semi_match_keywords' => $model->semiMatchKeywords,
            'content' => $model->content,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
