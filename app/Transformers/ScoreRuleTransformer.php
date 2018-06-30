<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ScoreRule;

/**
 * Class ScoreRuleTransformer.
 *
 * @package namespace App\Transformers;
 */
class ScoreRuleTransformer extends TransformerAbstract
{
    /**
     * Transform the ScoreRule entity.
     *
     * @param \App\Entities\ScoreRule $model
     *
     * @return array
     */
    public function transform(ScoreRule $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
