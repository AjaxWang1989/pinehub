<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatConfig;

/**
 * Class WechatConfigTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatConfigTransformer extends TransformerAbstract
{

    /**
     * Transform the WechatConfig entity.
     *
     * @param \App\Entities\WechatConfig $model
     *
     * @return array
     */
    public function transform(WechatConfig $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'app_id' => $model->appId,
            'app_name' => $model->appName,
            'app_secret' => $model->appSecret,
            'token' => $model->token,
            'aes_key' => $model->aesKey,
            'type' => $model->type,
            'mode' => $model->mode,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
