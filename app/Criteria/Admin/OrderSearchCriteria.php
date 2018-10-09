<?php

namespace App\Criteria\Admin;

use App\Entities\Order;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderSearchCriteria.
 *
 * @package namespace App\Criteria\Admin;
 */
class OrderSearchCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Order $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $beginAt = Request::input('begin_at', null);
        $endAt = Request::input('end_at', null);
        if($beginAt) {
            $model = $model->where('paid_at', '>', $beginAt);
        }

        if($endAt) {
            $model = $model->where('paid_at', '<', $endAt);
        }
        return $model;
    }
}
