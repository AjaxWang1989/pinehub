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
            'platform' => $model->platform,
            'sync'        => $model->sync,
            'status'      => $model->status,
            'sync_status' => $model->syncStatus,
            'begin_at' => $model->beginAt ? $model->beginAt->format('Y-m-d') : null,
            'end_at'   => $model->endAt ? $model->endAt->format('Y-m-d') : null,
            'issue_count'  => $model->issueCount,
            'created_at'  => $model->createdAt,
            'updated_at'  => $model->updatedAt
        ];
    }
}
