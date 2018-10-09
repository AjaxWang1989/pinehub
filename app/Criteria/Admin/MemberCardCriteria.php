<?php

namespace App\Criteria\Admin;

use App\Entities\Card;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MemberCardCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class MemberCardCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Card   $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model->whereAppId($appManager->currentApp->id)
            ->whereWechatAppId($appManager->officialAccount->appId);
        return $model;
    }
}
