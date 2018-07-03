<?php

namespace App\Criteria\Admin;

use App\Entities\WechatConfig;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WechatConfigCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class WechatConfigCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param  WechatConfig  $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appId = app(AppManager::class)->currentApp->id;
        $model->whereWechatBindApp($appId);
        return $model;
    }
}
