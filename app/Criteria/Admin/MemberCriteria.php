<?php

namespace App\Criteria\Admin;

use App\Entities\User;
use App\Entities\Order;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * @param User              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $appId = $appManager->currentApp->id;
        $model->whereAppId($appId)->with(['user.roles' => function (BelongsToMany $query) {
            return $query->where('slug', Role::MEMBER);
        }])->with(['customers'])->withCount(['orders' => function(HasMany $query) {
            return $query->whereNotNull('paid_at');
        }]);
        return $model;
    }
}
