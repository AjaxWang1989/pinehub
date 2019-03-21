<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Member;

/**
 * Class MemberTransformer.
 *
 * @package namespace App\Transformers;
 */
class MemberTransformer extends TransformerAbstract
{
    /**
     * Transform the Member entity.
     *
     * @param Member $model
     *
     * @return array
     */
    public function transform(Member $model)
    {
        return $model->toArray();
    }
}
