<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ScoreRule as ScoreRuleItem;

/**
 * Class ScoreRuleItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class ScoreRuleItemTransformer extends TransformerAbstract
{
    /**
     * Transform the ScoreRuleItem entity.
     *
     * @param ScoreRuleItem $model
     *
     * @return array
     */
    public function transform(ScoreRuleItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'type' => $model->type,
            'rule' => $model->rule,
            'expires_at' => $model->expiresAt,
            'app_id' => $model->appId,
            'score' => $model->score,
            'total_score' => $model->totalScore,
            /* place your other model properties here */

            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
