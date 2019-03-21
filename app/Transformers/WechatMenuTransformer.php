<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\WechatMenu;

/**
 * Class WechatMenuTransformer.
 *
 * @package namespace App\Transformers;
 */
class WechatMenuTransformer extends TransformerAbstract
{
    /**
     * Transform the WechatMenu entity.
     *
     * @param \App\Entities\WechatMenu $model
     *
     * @return array
     */
    public function transform(WechatMenu $model)
    {
        return [
            'id'         => (int) $model->id,
            /* place your other model properties here */
            'app_id' => $model->appId,
            'is_public' => $model->isPublic,
            'name' => $model->name,
            'menus' => $model->menus,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
