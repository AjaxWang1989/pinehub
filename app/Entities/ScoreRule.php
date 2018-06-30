<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\ScoreRule
 *
 * @property int $id
 * @property string $appId 系统应用appid
 * @property int $score 增加的积分数
 * @property int $totalScore 累计积分数
 * @property int $type 类型 0-通用规则 1-特殊规则
 * @property \Carbon\Carbon $expiresAt 过去日期，null表示永远有效
 * @property int $noticeUser 是否给用户发送积分通知
 * @property array $rule 积分自定义规则：{"focus": true, "order_count": 100, "order_amount"" 1000, "merchandise":null}
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereNoticeUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ScoreRule extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'expires_at' => 'date',
        'rule' => 'json'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id', 'score', 'type', 'expires_at', 'notice_user', 'rule'
    ];

    public function isFocusWechatOfficialAccountScore()
    {
        return isset($this->rule['focus']) ? $this->rule['focus'] : false;
    }

    public function isOrderCountScore()
    {
        return isset($this->rule['order_count']) ? !!$this->rule['order_count'] : false;
    }

    public function isOrderAmountScore()
    {
        return isset($this->rule['order_amount']) ? !!$this->rule['order_amount'] : false;
    }
}
