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
     * @return
     */
    public function transform(ScoreRule $model)
    {
        return [
            'id'         => (int) $model->id,
            'type' => $model->type,
            'rule' => $model->rule,
            'expires_at' => $model->expiresAt,
            'app_id' => $model->appId,
            'score' => $model->score,
            'total_score' => $model->totalScore,
            'notice_user' => $model->noticeUser,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
