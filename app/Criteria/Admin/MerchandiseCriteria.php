<?php

namespace App\Criteria\Admin;

use App\Entities\Merchandise;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MerchandiseCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class MerchandiseCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Merchandise           $model
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
