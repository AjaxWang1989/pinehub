<?php

namespace App\Repositories;

use App\Entities\Customer;
use Illuminate\Foundation\Application;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Interface RechargeableCardRepository.
 *
 * @package namespace App\Repositories;
 * @method pushCriteria(Application|\Laravel\Lumen\Application|RequestCriteria $app)
 */
interface RechargeableCardRepository extends RepositoryInterface
{
    /**
     * 卡片列表
     * @param Customer $customer 小程序用户
     * @param array $conditions 查询条件
     * @return array 查询结果 不分页
     */
    public function getList(Customer $customer, array $conditions): array;
}
