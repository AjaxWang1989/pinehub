<?php

namespace App\Criteria\Admin;

use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\Customer;
/**
 * Class CustomerCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class CustomerCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Customer             $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return tap($model, function (Customer $customer) {
            $appManager = app(AppManager::class);
            $appId = $appManager->currentApp->id;
            $customer->whereAppId($appId)
                ->groupBy('user_id');
        });
    }
}
