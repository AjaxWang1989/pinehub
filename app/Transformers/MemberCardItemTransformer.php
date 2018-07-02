<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MemberCardItem;

/**
 * Class MemberCardItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class MemberCardItemTransformer extends TransformerAbstract
{
    /**
     * Transform the MemberCardItem entity.
     *
     * @param \App\Entities\MemberCardItem $model
     *
     * @return array
     */
    public function transform(MemberCardItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
