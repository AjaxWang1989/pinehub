<?php

namespace App\Criteria\Admin;

use App\Entities\Order;
use App\Services\AppManager;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderCriteria.
 *
 *
 * @package namespace App\Criteria\Admin;
 */
class OrderCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Order   $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $appManager = app(AppManager::class);
        $model->whereAppId($appManager->currentApp->id);
        if(($shopId = Request::input('shop_id', null))) {
            $model->whereShopId($shopId);
        }
        return $model;
    }
}
