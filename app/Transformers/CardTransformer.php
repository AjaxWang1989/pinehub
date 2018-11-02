<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Card;

/**
 * Class CardTransformer.
 *
 * @package namespace App\Transformers;
 */
class CardTransformer extends TransformerAbstract
{
    /**
     * Transform the Card entity.
     *
     * @param \App\Entities\Card $model
     *
     * @return array
     */
    public function transform(Card $model)
    {
        return [
            'id' => (int)$model->id,
            'code'       => $model->code,
            'ticket_type' => $model->cardType,
            'ticket_info' => $model->cardInfo,
            'ticket_id'   => $model->cardId,
            'app_id'      => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'ali_app_id'  => $model->aliAppId,
            'sync'        => $model->sync,
            'status'      => $model->status,
            'begin_at'    => $model->beginAt,
            'end_at'      => $model->endAt,
            'created_at'  => $model->createdAt,
            'updated_at'  => $model->updatedAt
        ];
    }
}
