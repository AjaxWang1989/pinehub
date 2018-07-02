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
 * @property int $type 类型 0-通用规则 type & 8 == true 特殊规则
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

    const ORDER_COUNT_SCORE = 1;

    const ORDER_AMOUNT_SCORE = 2;

    const GENERAL_RULE = 0;

    const SPECIAL_RULE = 8;

    const SUBSCRIBE_RULE = 9;

    const ORDER_AMOUNT_RULE = 10;

    const ORDER_COUNT_RULE = 11;

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
        return $this->type === self::SUBSCRIBE_RULE;
    }

    public function isOrderCountScore()
    {
        return $this->type === self::ORDER_COUNT_RULE;
    }

    public function isOrderAmountScore()
    {
        return $this->type === self::ORDER_AMOUNT_RULE;
    }

    protected function buildScoreSettle($userId, $type, $contentKey, $scoreItem)
    {
        $scoreSettleCash = ScoreSettleCash::whereType($type)->orderByDesc('created_at')->first();
        if(!$scoreSettleCash && $scoreSettleCash->settled) {
            $scoreSettleCash = new ScoreSettleCash();
            $scoreSettleCash->type = $type;
            $scoreSettleCash->settled = false;
            $scoreSettleCash->score = $this->score;
            $scoreSettleCash->userId = $userId;
            $scoreSettleCash->scoreRuleId = $this->id;
            $scoreSettleCash->content = [
                $contentKey => 0
            ];
        }

        $scoreSettleCash->content[$contentKey] += $scoreItem;
        if($scoreSettleCash->content[$contentKey] >= $this->rule[$contentKey]) {
            $scoreSettleCash->settled = true;
        }
        return $scoreSettleCash;
    }
    public function orderScore(Order $order)
    {
        if($this->type === 1) {
            switch ($this->rule['type']) {
                case self::ORDER_AMOUNT_SCORE: {
                    $scoreSettleCash = $this->buildScoreSettle($order->buyerUserId, ScoreSettleCash::ORDER_AMOUNT_RULE,
                        'order_amount', $order->paymentAmount);
                    break;
                }
                case self::ORDER_COUNT_SCORE: {
                    $scoreSettleCash = $this->buildScoreSettle($order->buyerUserId, ScoreSettleCash::ORDER_COUNT_RULE,
                        'order_count', 1);
                    break;
                }
            }

            if(isset($scoreSettleCash)) {
                $scoreSettleCash->save();
                $scoreSettleCash->scoreUser->score += $scoreSettleCash->score;
                $scoreSettleCash->scoreUser->canUseScore += $scoreSettleCash->score;
                $scoreSettleCash->scoreUser->totalScore += $scoreSettleCash->score;
                $scoreSettleCash->scoreUser->save();
                if($scoreSettleCash->scoreUser->user) {
                    $scoreSettleCash->scoreUser->user->score += $scoreSettleCash->score;
                    $scoreSettleCash->scoreUser->user->canUseScore += $scoreSettleCash->score;
                    $scoreSettleCash->scoreUser->user->totalScore += $scoreSettleCash->score;
                    $scoreSettleCash->scoreUser->user->save();
                }
            }
        }
    }
}
