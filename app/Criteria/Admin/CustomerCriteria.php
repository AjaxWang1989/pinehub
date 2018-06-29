<?php

namespace App\Criteria\Admin;

use App\Entities\Role;
use App\Services\AppManager;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $model->with(['roles' => function (BelongsToMany $role) {
            $role->whereIn('slug', [Role::MEMBER, Role::CUSTOMER]);
        }, 'appUsers' => function (HasMany $appUsers) {
            $appManager = app(AppManager::class);
            $appUsers->where('app_id', $appManager->currentApp->id);
        }]);
        return $model;
    }
}
