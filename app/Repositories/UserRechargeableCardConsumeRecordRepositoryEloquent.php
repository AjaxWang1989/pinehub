<?php

namespace App\Repositories;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Validators\Admin\UserRechargeableCardConsumeRecordValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRechargeableCardConsumeRecordRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRechargeableCardConsumeRecordRepositoryEloquent extends BaseRepository implements UserRechargeableCardConsumeRecordRepository
{
    protected $fieldSearchable = [
        'type' => '=',
        'channel' => '=',
    ];

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
        $result = $this->scopeQuery(function ($query) {
            return $query->selectRaw("count(*) as buy_count,sum(consume) as consume_count,sum(amount-consume) as gift_count")
                ->where('type', UserRechargeableCardConsumeRecord::TYPE_BUY);
        })->get()[0]->toArray();
        $result['consume_count'] = number_format($result['consume_count'] / 100, 2);
        $result['gift_count'] = number_format($result['gift_count'] / 100, 2);

        /** @var UserRechargeableCardRepositoryEloquent $userRechargeableCardRepository */
        $userRechargeableCardRepository = app(UserRechargeableCardRepository::class);
        $balanceAmount = $userRechargeableCardRepository->scopeQuery(function ($query) {
            return $query->selectRaw("sum(amount) as balance_amount");
        })->get()[0]->toArray();
        $balanceAmount['balance_amount'] = number_format($balanceAmount['balance_amount'] / 100, 2);

        $return = array_merge($result, $balanceAmount);

        return $return;
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
        $searchStr = Request::query('searchJson', null);
        Log::info('search fields', [$searchStr]);
        if ($searchStr) {
            $searchJson = is_array($searchStr) ? $searchStr : json_decode(urldecode(base64_decode($searchStr)), true);
            $params = array_merge($params, $searchJson);
        }
        Log::info('最终参数：', [$params]);

        $recordPaginator = $this->scopeQuery(function ($consumeRecord) use ($params) {
            return $consumeRecord->where(function (Builder $query) use ($params) {
                if (isset($params['created_at'])) {
                    $query->whereDate('created_at', '>=', $params['created_at'][0])
                        ->whereDate('created_at', '<', $params['created_at'][1]);
                }
            });
        })->whereHas('user', function ($query) use ($params) {
            if (isset($params['user_mobile'])) {
                $query->where('mobile', $params['user_mobile']);
            }
            if (isset($params['user_nickname'])) {
                $query->where('nickname', 'like', '%' . $params['user_nickname'] . '%');
            }
        })->whereHas('rechargeableCard', function ($query) use ($params) {
            if (isset($params['rechargeable_card_name'])) {
                $query->where('name', 'like', '%' . $params['rechargeable_card_name'] . '%');
            }
        })->orderBy('created_at', 'desc')->paginate(request()->input('limit', PAGE_LIMIT));

        return $recordPaginator;
        /*
          ->whereHas('user', function ($query) use ($params) {
            if (isset($params['user_mobile'])) {
                $query->where('mobile', $params['user_mobile']);
            }
            if (isset($params['user_nickname'])) {
                $query->where('nickname', 'like', '%' . $params['user_nickname'] . '%');
            }
        })
         */
    }
}
