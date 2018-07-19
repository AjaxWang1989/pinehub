<?php

namespace App\Criteria\Admin;

use App\Entities\OrderGift;
use App\Services\AppManager;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderGiftCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class OrderGiftCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param OrderGift    $model
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
