<?php

namespace App\Repositories;

use Illuminate\Foundation\Application;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Interface UserRechargeableCardConsumeRecordRepository.
 *
 * @package namespace App\Repositories;
 * @method pushCriteria(Application|\Laravel\Lumen\Application|RequestCriteria $app)
 */
interface UserRechargeableCardConsumeRecordRepository extends RepositoryInterface
{
    /**
     * @param array $params
     * @return array 查询参数，如用户，
     * 获取统计数据
     * 包括但不限于：储值总额，储值次数，账户余额，获赠总额
     */
    public function getStatistics(array $params): array;

    /**
     * 获取消费列表
     * @param array $params
     * @return mixed
     */
    public function getList(array $params);
}
