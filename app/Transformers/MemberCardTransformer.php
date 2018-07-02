<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MemberCard;

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
     * @param \App\Entities\MemberCard $model
     *
     * @return array
     */
    public function transform(MemberCard $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
