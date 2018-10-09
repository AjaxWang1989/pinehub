<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Card as CardItem;

/**
 * Class CardItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CardItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CardItem entity.
     *
     * @param CardItem $model
     *
     * @return array
     */
    public function transform(CardItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'color'      => $model->cardInfo['base_info']['color'],
            'background_pic_url' => $model->cardInfo['background_pic_url'],
            'logo_url' => $model->cardInfo['logo_url'],
            'card_type' => $model->cardType,
            'brand_name' => $model->cardInfo['brand_name'],
            'code_type'  => $model->cardInfo['code_type'],
            'title' => $model->cardInfo['title'],
            'sku' => $model->cardInfo['sku'],
            'app_id' => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'ali_app_id' => $model->aliAppId,
            'status' => $model->status,
            'sync' => $model->sync,
            'begin_at' => $model->beginAt,
            'end_at' => $model->endAt,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
