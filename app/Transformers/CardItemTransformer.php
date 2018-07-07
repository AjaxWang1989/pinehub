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
        \Log::debug('card info', ['cash' => isset($model->cardInfo['reduce_cost']) , 'discount' => isset($model->cardInfo['discount']) ]);
        return [
            'id'         => (int) $model->id,
            'color'      => $model->cardInfo['base_info']['color'],
            //'background_pic_url' => $model->cardInfo['background_pic_url'],
            //'logo_url' => $model->cardInfo['base_info']['logo_url'],
            'card_type' => $model->cardType,
            'brand_name' => $model->cardInfo['base_info']['brand_name'],
            'code_type'  => $model->cardInfo['base_info']['code_type'],
            'title' => $model->cardInfo['base_info']['title'],
            'sku' => $model->cardInfo['base_info']['sku'],
            'app_id' => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'ali_app_id' => $model->aliAppId,
            'status' => $model->status,
            'sync' => $model->sync,
            'begin_at' => $model->beginAt,
            'end_at' => $model->endAt,
            'least_cost' => isset($model->cardInfo['least_cost']) ? $model->cardInfo['least_cost'] : (isset($model->cardInfo['advanced_info']) &&
                isset($model->cardInfo['advanced_info']['use_condition']) && isset($model->cardInfo['advanced_info']['use_condition']['least_cost'])
                ? $model->cardInfo['advanced_info']['use_condition']['least_cost'] : null),
            'reduce_cost' => isset($model->cardInfo['reduce_cost']) ? $model->cardInfo['reduce_cost'] : null,
            'discount' => isset($model->cardInfo['discount']) ? $model->cardInfo['discount'] : null,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
