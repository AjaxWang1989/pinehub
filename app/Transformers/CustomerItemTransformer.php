<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Transformers;

use App\Entities\Role;
use League\Fractal\TransformerAbstract;
use App\Entities\Customer as CustomerItem;

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
            'is_member'  => !!$model->memberId,
            'nickname'   => $model->nickname,
            'score'  => $model->score,
            'app_id' => $model->appId,
            'channel' => $model->channel,
            'register_channel' => $model->registerChannel,
            'order_count' => $model->ordersNum() ? $model->ordersNum() : 0,
            'total_score' => $model->totalScore,
            'can_use_score' => $model->canUseScore,
            'tags'  => $model->tags,
            'sex' => $model->sex,
            /* place your other model properties here */
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        );
    }
}
