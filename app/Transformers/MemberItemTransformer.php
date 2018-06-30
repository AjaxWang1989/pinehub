<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Transformers;

use App\Entities\WechatUser;
use League\Fractal\TransformerAbstract;
use App\Entities\User as MemberItem;

/**
 * Class MemberItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class MemberItemTransformer extends TransformerAbstract
{
    /**
     * Transform the MemberItem entity.
     *
     * @param MemberItem $model
     *
     * @return array
     */
    public function transform(MemberItem $model)
    {
        return array(
            'id'         => (int) $model->id,
            'nickname'   => $model->nickname,
            'mobile'     => $model->mobile,
            'official_account' => !$model->officialAccountUser ? null : $model->officialAccountUser->only(array('nickname', 'avatar', 'sex', 'country', 'province', 'city')),
            'mini_program' => !$model->miniProgramUser ? null : $model->miniProgramUser->only(array('nickname', 'avatar', 'sex', 'country', 'province', 'city')),
            /* place your other model properties here */
            'app_id' => $model->appId,
            'channel' => $model->channel,
            'register_channel' => $model->registerChannel,
            'order_count' => $model->ordersCount,
            'tags'  => $model->tags,
            'score' => $model->score,
            'card' => '待开发',
            'status' => $model->status,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        );
    }
}
