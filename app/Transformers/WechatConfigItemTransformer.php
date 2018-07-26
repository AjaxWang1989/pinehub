<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatConfig as WechatConfigItem;

/**
 * Class WechatConfigItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatConfigItemTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatConfigItem entity.
     *
     * @param WechatConfigItem $model
     *
     * @return array
     */
    public function transform(WechatConfigItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'app_id' => $model->appId,
            'app_name' => $model->appName,
            'mode' => $model->mode,
            'type' => $model->type,
            'nickname' => $model->nickname,
            'head_img' => $model->headImg,
            'user_name' => $model->userName,
            'alias' => $model->alias,
            'principal_name' => $model->principalName,
            'service_type_info' => $model->serviceTypeInfo,
            'business_info' => $model->businessInfo,
            'func_info' => $model->funcInfo,
            'qr_code' => $model->qrcodeUrl,
            'wechat_bind_app' => $model->wechatBindApp,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
