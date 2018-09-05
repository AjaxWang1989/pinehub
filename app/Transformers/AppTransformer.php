<?php

namespace App\Transformers;

use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Entities\App;

/**
 * Class AppTransformer.
 *
 * @package namespace App\Transformers;
 */
class AppTransformer extends TransformerAbstract
{
    /**
     * Transform the App entity.
     *
     * @param \App\Entities\App $model
     *
     * @return array
     */
    public function transform(App $model)
    {
//        return [
//            'id'         => $model->id,
//            'name' => $model->name,
//            'mini_app_id' => $model->miniAppId,
//            'wechat_app_id' => $model->wechatAppId,
//            'secret' => $model->secret,
//            'logo' => $model->logo,
//            /* place your other model properties here */
//
//            'created_at' => $model->createdAt,
//            'updated_at' => $model->updatedAt
//        ];
        return [
            'access_token' => $model['access_token'],
        ];
    }
}
