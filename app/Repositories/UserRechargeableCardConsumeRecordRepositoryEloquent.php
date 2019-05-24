<?php

namespace App\Repositories;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Validators\Admin\UserRechargeableCardConsumeRecordValidator;
use Illuminate\Database\Eloquent\Builder;
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
     * @param array $params 查询参数
     * params consists of : [
     *      user_mobile,user_nickname ...
     * ]
     * @return mixed
     */
    public function getList(array $params)
    {
        $recordPaginator = $this->scopeQuery(function ($consumeRecord) use ($params) {
            return $consumeRecord->where(function (Builder $query) use ($params) {
                if (isset($params['type'])) {
                    $query->where('type', $params['type']);
                }
                if (isset($params['channel'])) {
                    $query->where('channel', '=', $params['channel']);
                }
                if (isset($params['start_at'])) {
                    $query->whereDate('created_at', '<=', $params['start_at']);
                }
                if (isset($params['end_at'])) {
                    $query->whereDate('created_at', '>=', $params['end_at']);
                }
            });
        })->with([
            'user' => function ($query) use ($params) {
                if (isset($params['user_mobile'])) {
                    $query->whereMobile($params['user_mobile']);
                }
                if (isset($params['user_nickname'])) {
                    $query->whereOr('nick_name', 'like', '%' . $params['user_nickname'] . '%');
                }
            },
            'rechargeableCard' => function ($query) use ($params) {
                if (isset($params['rechargeable_card_name'])) {
                    $query->where('name', 'like', '%' . $params['rechargeable_card_name'] . '%');
                }
            }
        ])->orderBy('created_at', 'desc')->paginate(request()->input('limit', PAGE_LIMIT));

        return $recordPaginator;
    }
}
