<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Card as MemberCardItem;

/**
 * Class MemberCardItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class MemberCardItemTransformer extends TransformerAbstract
{
    /**
     * Transform the MemberCardItem entity.
     *
     * @param MemberCardItem $model
     *
     * @return array
     */
    public function transform(MemberCardItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'color'      => isset($model->cardInfo['base_info']['color']) ? $model->cardInfo['base_info']['color'] : null,
            'background_material_id' => isset($model->cardInfo['background_material_id'])? $model->cardInfo['background_material_id'] : null,
            'background_pic_url' => isset($model->cardInfo['background_pic_url'])? $model->cardInfo['background_pic_url'] : null,
            'logo_url' => isset($model->cardInfo['base_info']['logo_url']) ? $model->cardInfo['base_info']['logo_url'] : null  ,
            'card_type' => $model->cardType,
            'brand_name' => isset($model->cardInfo['base_info']['brand_name']) ? $model->cardInfo['base_info']['brand_name'] : null,
            'code_type'  => isset($model->cardInfo['base_info']['code_type']) ? $model->cardInfo['base_info']['code_type'] : null ,
            'title' => isset($model->cardInfo['base_info']['title']) ? $model->cardInfo['base_info']['title'] : null,
            'sku' => isset($model->cardInfo['base_info']['sku']) ? $model->cardInfo['base_info']['sku'] : null,
            'app_id' => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'ali_app_id' => $model->aliAppId,
            'status' => $model->status,
            'sync' => $model->sync,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
