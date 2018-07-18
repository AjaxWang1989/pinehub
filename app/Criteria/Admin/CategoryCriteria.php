<?php

namespace App\Criteria\Admin;

use App\Entities\Category;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CategoryCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class CategoryCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Category        $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model->whereAppId($appManager->currentApp->id);
        return $model;
    }
}
