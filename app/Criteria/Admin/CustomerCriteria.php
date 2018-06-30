<?php

namespace App\Criteria\Admin;

use App\Entities\Role;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\User as Customer;
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
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $model->where('app_id', $appId)->with(['roles' => function ($query) {
            return $query->whereIn('slug', [Role::CUSTOMER, Role::MEMBER]);
        }, 'officialAccountUser' => function($query) use($appId) {
            return $query->where('app_id', $appId);
        }, 'miniProgramUser' => function($query) use($appId) {
            return $query->where('app_id', $appId);
        }])->withCount(['orders' => function ($query) {
            $query->whereNotNull('pay_at');
        }]);
        return $model;
    }
}
