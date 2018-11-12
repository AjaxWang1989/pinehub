<?php

namespace App\Criteria\Admin;

use App\Entities\Activity;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NewMerchandiseActivityCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class NewMerchandiseActivityCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Activity              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('app_id', app(AppManager::class)->getAppId());
        $model = $model->where('type', Activity::NEW_PRODUCT_ACTIVITY);
        $model = $model->where('status', Activity::HAVE_IN_HAND);
        return $model;
    }
}
