<?php

namespace App\Criteria\Admin;

use App\Entities\WechatMenu;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WechatMenuCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class WechatMenuCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param WechatMenu $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model->whereAppId($appManager->officialAccount->id);
        return $model;
    }
}
