<?php

namespace App\Transformers;

use App\Services\AppManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Entities\Card as CardItem;

/**
 * Class TicketItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class TicketItemTransformer extends TransformerAbstract
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
        $activeTime = '';
        if (isset($model->cardInfo['base_info']) && isset($model->cardInfo['base_info']['date_info'])) {
            switch ($model->cardInfo['base_info']['date_info']['type']) {
                case DATE_TYPE_FIX_TIME_RANGE:
                    {
                        $activeTime .= Carbon::createFromTimestamp($model->cardInfo['base_info']['date_info']['begin_timestamp'], config('app.timezone'))
                            ->format('Y-m-d H:i:s');
                        $activeTime .= ' - ';
                        $activeTime .= Carbon::createFromTimestamp($model->cardInfo['base_info']['date_info']['end_timestamp'], config('app.timezone'))
                            ->format('Y-m-d H:i:s');
                        break;
                    }
                case DATE_TYPE_FIX_TERM:
                    {
                        if ($model->cardInfo['base_info']['date_info']['fixed_begin_term']) {
                            $activeTime .= "领取后{$model->cardInfo['base_info']['date_info']['fixed_begin_term']}天生效，
                    有效期{$model->cardInfo['base_info']['date_info']['fixed_term']}天。";
                        } else {
                            $activeTime .= "领取生效，有效期{$model->cardInfo['base_info']['date_info']['fixed_term']}天。";
                        }
                        break;
                    }
            }
        }

        return [
            'id' => (int)$model->id,
            'code' => $model->code,
            'card_id' => (string)$model->cardId,
            'card_type' => strtoupper($model->cardType),
            'title' => isset($model->cardInfo['base_info']['title']) ? $model->cardInfo['base_info']['title'] : null,
            'sku' => isset($model->cardInfo['base_info']['sku']) ? $model->cardInfo['base_info']['sku'] : null,
            'app_id' => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'ali_app_id' => $model->aliAppId,
            'status' => $model->status,
            'status_desc' => $model->statusDesc,
            'sync_status' => $model->syncStatus,
            'sync' => $model->sync,
            'platform' => $model->platform,
            'begin_at' => $model->beginAt ? $model->beginAt->format('Y-m-d') : null,
            'end_at' => $model->endAt ? $model->endAt->format('Y-m-d') : null,
            'active_time' => $activeTime,
            'least_cost' => isset($model->cardInfo['least_cost']) ? $model->cardInfo['least_cost'] : (isset($model->cardInfo['advanced_info']) &&
            isset($model->cardInfo['advanced_info']['use_condition']) && isset($model->cardInfo['advanced_info']['use_condition']['least_cost'])
                ? $model->cardInfo['advanced_info']['use_condition']['least_cost'] : null),
            'reduce_cost' => isset($model->cardInfo['reduce_cost']) ? $model->cardInfo['reduce_cost'] : null,
            'discount' => isset($model->cardInfo['discount']) ? $model->cardInfo['discount'] : null,
            'get_limit' => isset($model->cardInfo['base_info']['get_limit']) ? $model->cardInfo['base_info']['get_limit'] : null,
            /* place your other model properties here */
            'quantity' => $model->issueCount ? ($model->issueCount - $model->userGetCount) : 0,
            'issue_count' => $model->issueCount,
            'used_count' => $model->usedCount,
            'user_get_count' => $model->userGetCount,
            'used_rate' => $model->userGetCount ? $model->usedCount / $model->userGetCount : 0,
            'promote_url' => buildUrl('api.backend', '/ticket/{ticketId}/promote/qrcode', ['ticketId' => $model->id]),//TODO
            'promote_minicode_url' => buildUrl('api.backend', '/ticket/{ticketId}/promote/minicode',
                ['ticketId' => $model->id],
                ['project_id' => app(AppManager::class)->getAppId()]),
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
