<?php

namespace App\Repositories;

use App\Entities\Customer;
use App\Entities\RechargeableCard;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Interface RechargeableCardRepository.
 *
 * @package namespace App\Repositories;
 * @method pushCriteria(\Illuminate\Foundation\Application|\Laravel\Lumen\Application|RequestCriteria $app)
 */
interface RechargeableCardRepository extends RepositoryInterface
{
    /**
     * 卡片列表
     * @param Customer $customer 小程序用户
     * @param array $conditions 查询条件
     * @return Collection 查询结果 不分页
     */
    public function getList(Customer $customer, array $conditions): Collection;

    /**
     * 用户购买卡片
     * @param Customer $customer 小程序用户
     * @param RechargeableCard $rechargeableCard 被购买卡片
     * @return mixed
     */
    public function buy(Customer $customer, RechargeableCard $rechargeableCard);
}
