<?php

namespace App\Excel\generators;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\UserRechargeableCardConsumeRecord;
use App\Excel\BaseGenerator;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Criteria\RequestCriteria;

class ConsumeRecordGenerator extends BaseGenerator
{

    /**
     * 表头
     * @return mixed
     */
    public function header()
    {
        return [
            ['key' => 'code', 'desc' => '订单编号', 'width' => 20],
            ['key' => 'type', 'desc' => '类型', 'width' => 10],
            ['key' => 'nickname', 'desc' => '用户昵称', 'width' => 20],
            ['key' => 'mobile', 'desc' => '手机号码', 'width' => 15],
            ['key' => 'rechargeableCardName', 'desc' => '储值卡名称', 'width' => 15],
            ['key' => 'consume', 'desc' => '消费(元)', 'width' => 15],
            ['key' => 'rechargeableCardGift', 'desc' => '赠送金额(元)', 'width' => 15],
            ['key' => 'channel', 'desc' => '充值途径', 'width' => 15],
            ['key' => 'createdAt', 'desc' => '时间', 'width' => 20]
        ];
    }

    public function getNickname(UserRechargeableCardConsumeRecord $model)
    {
        return $model->user ? $model->user->nickname : '';
    }

    public function getRechargeableCardName(UserRechargeableCardConsumeRecord $model)
    {
        return $model->rechargeableCard ? $model->rechargeableCard->name : '';
    }

    public function getRechargeableCardAmount(UserRechargeableCardConsumeRecord $model)
    {
        return $model->rechargeableCard ? number_format($model->rechargeableCard->amount / 100, 2) : 0;
    }

    public function getMobile(UserRechargeableCardConsumeRecord $model)
    {
        return $model->user ? $model->user->mobile : '';
    }

    public function getRechargeableCardGift(UserRechargeableCardConsumeRecord $model)
    {
        return $model->rechargeableCard ? number_format(($model->rechargeableCard->amount - $model->consume) / 100, 2) : 0;
    }

    public function getChannel(UserRechargeableCardConsumeRecord $model)
    {
        return $model->channelDesc;
    }

    public function getCode(UserRechargeableCardConsumeRecord $model)
    {
        return $model->order ? $model->order->code : '';
    }

    public function getCreatedAt(UserRechargeableCardConsumeRecord $model)
    {
        return (string)$model->createdAt;
    }

    public function getType(UserRechargeableCardConsumeRecord $model)
    {
        return $model->typeDesc;
    }

    public function getConsume(UserRechargeableCardConsumeRecord $model)
    {
        return number_format($model->consume / 100, 2);
    }

    /**
     * 表数据
     * @param array $params 查询参数
     * @return mixed
     */
    public function bodyData(array $params)
    {
        $consumeRecordRepository = app(UserRechargeableCardConsumeRecordRepository::class);

        $consumeRecordRepository->pushCriteria(app(RequestCriteria::class));

        $consumeRecordRepository->pushCriteria(app(SearchRequestCriteria::class));

        $data = $consumeRecordRepository->with(['user', 'rechargeableCard', 'order'])->scopeQuery(function (Builder $query) use ($params) {
            return $query->where(function (Builder $query) use ($params) {
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
        })->orderBy($params['order_by'] ?? 'created_at', $params['order_direction'] ?? 'asc')->all();

        return $data;
    }

    /**
     * 表名
     * @return mixed
     */
    public function fileName()
    {
        return '储值记录';
    }
}