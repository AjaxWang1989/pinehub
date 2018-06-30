<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Transformers;

use App\Entities\Role;
use App\Entities\User;
use League\Fractal\TransformerAbstract;
use App\Entities\User as CustomerItem;

/**
 * Class CustomerItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class CustomerItemTransformer extends TransformerAbstract
{
    /**
     * Transform the CustomerItem entity.
     *
     * @param CustomerItem $model
     *
     * @return array
     */
    public function transform(CustomerItem $model)
    {
        return array(
            'id'         => (int) $model->id,
            'is_member'  => $model->roles->where('slug', Role::MEMBER)->count() > 0,
            'nickname'   => $model->nickname,
            'user_name'  => $model->userName,
            'score'  => $model->score,
            'app_id' => $model->appId,
            'channel' => $model->channel,
            'register_channel' => $model->registerChannel,
            'order_count' => $model->ordersCount,
            'tags'  => $model->tags,
            'official_account' => !$model->officialAccountUser ? null : $model->officialAccountUser->only(array('nickname', 'avatar', 'sex', 'country', 'province', 'city')),
            'mini_program' => !$model->miniProgramUser ? null : $model->miniProgramUser->only(array('nickname', 'avatar', 'sex', 'country', 'province', 'city')),
            /* place your other model properties here */
            'status' => $model->status,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        );
    }
}
