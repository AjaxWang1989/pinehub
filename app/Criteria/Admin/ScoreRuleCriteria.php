<?php

namespace App\Criteria\Admin;

use App\Entities\ScoreRule;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ScoreRuleCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class ScoreRuleCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param ScoreRule  $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        return $model->whereAppId($appManager->currentApp->id);
    }
}
