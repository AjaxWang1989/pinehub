<?php

namespace App\Criteria\Admin;

use App\Entities\User;
use App\Entities\Order;
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
     * @param User              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $model->whereAppId($appId)->with(['user.roles' => function ($query) {
            return $query->where('slug', Role::MEMBER);
        }])->with(['customers'])->withCount(['orders' => function($query) {
            return $query->whereNotNull('paid_at');
        }]);
        return $model;
    }
}
