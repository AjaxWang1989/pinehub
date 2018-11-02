<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Ticket;

/**
 * Class TicketTransformer.
 *
 * @package namespace App\Transformers;
 */
class TicketTransformer extends TransformerAbstract
{
    /**
     * Transform the Card entity.
     *
     * @param Ticket $model
     *
     * @return array
     */
    public function transform(Ticket $model)
    {
        return [
            'id' => (int)$model->id,
            'code'       => $model->code,
            'ticket_type' => mb_strtoupper($model->cardType),
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