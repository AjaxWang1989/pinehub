<?php

namespace App\Criteria\Admin;

use App\Entities\Role;
use App\Entities\Member;
use App\Services\AppManager;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MemberCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class MemberCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Member             $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $model = $model->where('app_id', $appId)->with(['customers.orders' => function(HasMany $query) {
            $query->whereNotNull('paid_at');
        }]);
        return $model;
    }
}
