<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\UserRechargeableCardConsumeRecord
 * @property int id
 * @property int $userId 用户会员ID
 * @property int $customerId 用户ID
 * @property int $orderId 订单ID
 * @property int $rechargeableCardId 卡片ID
 * @property int $userRechargeableCardId
 * @property int $type 类型 1->充值 2->消费
 * @property int $amount 卡内金额
 * @property int $channel 途径|通道
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property-read string $typeDesc
 * @property-read string $channelDesc
 * @property int $consume 消费金额，单位：分
 * @property int $save 节省金额，单位：分
 * @property-read Order $order 所属订单
 * @property-read User $user 所属用户
 * @property-read RechargeableCard $rechargeableCard 关联卡片
 * @property-read UserRechargeableCard $userRechargeableCard
 * @method static Builder|UserRechargeableCardConsumeRecord whereId($value)
 * @method static Builder|UserRechargeableCardConsumeRecord whereUserId($value)
 * @method static Builder|UserRechargeableCardConsumeRecord whereCustomerId($value)
 * @method static Builder|UserRechargeableCardConsumeRecord whereOrderId($value)
 * @method static Builder|UserRechargeableCardConsumeRecord whereType($value)
 * @method static Builder|UserRechargeableCardConsumeRecord whereRechargeableCardId($value)
 * @method static Builder|UserRechargeableCardConsumeRecord newModelQuery()
 * @method static Builder|UserRechargeableCardConsumeRecord newQuery()
 * @method static Builder|UserRechargeableCardConsumeRecord query()
 * @mixin \Eloquent
 */
class UserRechargeableCardConsumeRecord extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const TYPE_BUY = 1;
    const TYPE_CONSUME = 2;
    const TYPES = [
        self::TYPE_BUY => '充值',
        self::TYPE_CONSUME => '消费'
    ];
    const SIGNS = [
        self::TYPE_BUY => '+',
        self::TYPE_CONSUME => '-'
    ];

    const CHANNELS = [
        self::CHANNEL_WX => '微信小程序',
        self::CHANNEL_WX_CODE_SWEEP_PAYMENT => '微信扫码付',
        self::CHANNEL_WX_BALANCE_CENTER => '微信小程序余额中心',
        self::CHANNEL_ALI => '支付宝小程序'
    ];
    const CHANNEL_WX = 100;// 仅表明微信小程序
    const CHANNEL_WX_CODE_SWEEP_PAYMENT = 101;// 微信小程序扫码付
    const CHANNEL_WX_BALANCE_CENTER = 102;// 微信小程序余额中心
    const CHANNEL_ALI = 200;// 仅表明支付宝小程序

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'customer_id', 'order_id', 'rechargeable_card_id', 'user_rechargeable_card_id', 'type', 'amount', 'channel', 'consume', 'save'];

    // 订单
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // 会员
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 用户
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // 卡片
    public function rechargeableCard(): BelongsTo
    {
        return $this->belongsTo(RechargeableCard::class, 'rechargeable_card_id')->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function userRechargeableCard(): BelongsTo
    {
        return $this->belongsTo(UserRechargeableCard::class, 'user_rechargeable_card_id');
    }

    // 类型描述
    public function getTypeDescAttribute(): string
    {
        return self::TYPES[$this->type];
    }

    public function getChannelDescAttribute(): string
    {
        return self::CHANNELS[$this->channel];
    }

}
