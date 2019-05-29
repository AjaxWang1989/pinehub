<?php

namespace App\Excel\generators;

use App\Entities\UserRechargeableCardConsumeRecord;
use App\Excel\BaseGenerator;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use Illuminate\Database\Eloquent\Builder;

class DepositRecordGenerator extends BaseGenerator
{

    /**
     * 表头
     * @return mixed
     */
    public function header()
    {
        return [
            ['key' => 'code', 'desc' => '订单编号'],
            ['key' => 'nickname', 'desc' => '用户昵称'],
            ['key' => 'mobile', 'desc' => '手机号码'],
            ['key' => 'rechargeableCardName', 'desc' => '储值卡名称'],
            ['key' => 'rechargeableCardAmount', 'desc' => '充值金额'],
            ['key' => 'rechargeableCardGift', 'desc' => '赠送金额'],
            ['key' => 'channel', 'desc' => '充值途径'],
            ['key' => 'createdAt', 'desc' => '时间']
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
        return $model->rechargeableCard ? number_format($model->rechargeableCard->amount, 2) : 0;
    }

    public function getMobile(UserRechargeableCardConsumeRecord $model)
    {
        return $model->user ? $model->user->mobile : '';
    }

    public function getRechargeableCardGift(UserRechargeableCardConsumeRecord $model)
    {
        return $model->rechargeableCard ? number_format(($model->rechargeableCard->amount - $model->consume), 2) : 0;
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

    /**
     * 表数据
     * @param array $params 查询参数
     * @return mixed
     */
    public function bodyData(array $params)
    {
        $consumeRecordRepository = app(UserRechargeableCardConsumeRecordRepository::class);

        $data = $consumeRecordRepository->with(['user', 'rechargeableCard', 'order'])->scopeQuery(function (Builder $query) {
            return $query;
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