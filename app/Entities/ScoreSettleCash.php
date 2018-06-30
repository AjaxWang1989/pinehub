<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\ScoreSettleCash
 *
 * @property int $id
 * @property int|null $orderId 订单
 * @property int|null $scoreRuleId 积分规则id
 * @property int $score 积分数
 * @property int $type 规则类型：0 - 通用规则， 1 - 特殊规则
 * @property string $scoreRuleName 积分规则名称
 * @property int $userId 被积分用户id
 * @property int $settled
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScoreRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScoreRuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereSettled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereUserId($value)
 * @mixin \Eloquent
 */
class ScoreSettleCash extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
