<?php

namespace App\Repositories;

use App\Entities\Customer;
use App\Entities\RechargeableCard;
use App\Entities\UserRechargeableCard;
use App\Validators\Admin\RechargeableCardValidator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RechargeableCardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RechargeableCardRepositoryEloquent extends BaseRepository implements RechargeableCardRepository
{
    protected $fieldSearchable = [
        'status' => '=',
        'price' => 'between',
        'discount' => 'between',
        'category_id' => '=',
        'card_type' => '=',
        'type' => '=',
        'on_sale' => '=',
        'is_recommend' => '=',
        'name' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RechargeableCard::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return RechargeableCardValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 卡片列表
     * @param Customer $customer 小程序用户
     * @param array $conditions 查询条件
     * @return Collection 查询结果 不分页
     */
    public function getList(Customer $customer, array $conditions): Collection
    {
        // TODO: Implement getList() method.
    }

    /**
     * 用户购买卡片
     * @param Customer $customer 小程序用户
     * @param RechargeableCard $rechargeableCard 被购买卡片
     * @return UserRechargeableCard 返回购买记录
     */
    public function buy(Customer $customer, RechargeableCard $rechargeableCard): UserRechargeableCard
    {
        // TODO: Implement buy() method.
    }
}
