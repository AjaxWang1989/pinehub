<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\App as AppItem;

/**
 * Class AppItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class AppItemTransformer extends TransformerAbstract
{
    /**
     * Transform the AppItem entity.
     *
     * @param AppItem $model
     *
     * @return array
     */
    public function transform(AppItem $model)
    {
        return [
            'id'         => $model->id,
            'name' => $model->name,
            'mini_app_id' => $model->miniAppId,
            'wechat_app_id' => $model->wechatAppId,
            'secret' => $model->secret,
            'logo' => $model->logo,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
