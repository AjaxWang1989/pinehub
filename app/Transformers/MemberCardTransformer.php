<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Card as MemberCard;

/**
 * Class MemberCardTransformer.
 *
 * @package namespace App\Transformers;
 */
class MemberCardTransformer extends TransformerAbstract
{
    /**
     * Transform the MemberCard entity.
     *
     * @param MemberCard $model
     *
     * @return array
     */
    public function transform(MemberCard $model)
    {
        return [
            'id'         => (int) $model->id,
            'card_type' => $model->cardType,
            'member_info' => $model->cardInfo,
            'app_id' => $model->appId,
            'wechat_app_id' => $model->wechatAppId,
            'status' => $model->status,
            'sync' => $model->sync,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
