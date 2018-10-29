<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\ScoreSettleCash
 *
 * @property int $id
 * @property int|null $scoreRuleId 积分规则id
 * @property int $score 积分数
 * @property int $type 规则类型：0 - 通用规则, type & 8 == true 特殊规则
 * @property string $scoreRuleName 积分规则名称
 * @property array $content 积分项目
 * @property int $userId 被积分用户id
 * @property int $settled
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Customer $scoreUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereId($value)
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
    use TransformableTrait, ModelAttributesAccess;

    const GENERAL_RULE = 0;

    const SPECIAL_RULE = 8;

    const SUBSCRIBE_RULE = 9;

    const ORDER_AMOUNT_RULE = 10;

    const ORDER_COUNT_RULE = 11;

    protected $casts = [
        'content' => 'json'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'score_rule_id',
        'score',
        'user_id',
        'type',
        'content',
        'score_rule_name',
        'settled'
    ];

    public function scoreUser() : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

}
