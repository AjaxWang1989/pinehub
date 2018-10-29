<?php

namespace App\Criteria\Admin;

use App\Entities\PaymentActivity;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PaymentActivityCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class PaymentActivityCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param PaymentActivity    $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model->whereAppId(app(AppManager::class)->currentApp->id);
        return $model;
    }
}
