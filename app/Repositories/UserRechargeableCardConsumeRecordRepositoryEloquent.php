<?php

namespace App\Repositories;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Validators\Admin\UserRechargeableCardConsumeRecordValidator;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRechargeableCardConsumeRecordRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRechargeableCardConsumeRecordRepositoryEloquent extends BaseRepository implements UserRechargeableCardConsumeRecordRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserRechargeableCardConsumeRecord::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return UserRechargeableCardConsumeRecordValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $params
     * @return array 查询参数，如用户，
     * 获取统计数据
     * 包括但不限于：储值总额，储值次数，账户余额，获赠总额
     */
    public function getStatistics(array $params): array
    {

    }

    /**
     * 获取消费列表
     */
    public function getList()
    {
        $this->scopeQuery(function (UserRechargeableCardConsumeRecord $consumeRecord) use ($params) {
            return $consumeRecord->where(function (Builder $query) use ($params) {
                if (isset($params['mobile'])) {
                    $query->
                }
            });
        });
    }
}
