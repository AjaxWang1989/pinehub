<?php
/**
 * UserRechargeableCard.php
 * User: katherine
 * Date: 19-5-13 下午5:32
 */

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Entities\UserRechargeableCard
 *
 * @property int $id
 * @property int $userId 用户会员ID
 * @property int $customerId 用户ID
 * @property int $rechargeableCardId 卡种ID
 * @property int $orderId 订单ID
 * @property int $amount 卡内余额，初始值为卡内设定余额，逾期不可用
 * @property Carbon $validAt 卡种生效时间
 * @property Carbon|null $invalidAt 卡种失效时间
 * @property bool $isAutoRenew 是否自动续费，默认否
 * @property int $status 用户持有卡种状态 1=>有效 2=>失效 3=>已自动失效
 * @property-read string $statusDesc
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property-read Order $order 订单
 * @property-read User $user 会员
 * @property-read Customer $customer 用户
 * @property-read RechargeableCard $rechargeableCard
 * @method static bool|null forceDelete()
 * @method static Builder|UserRechargeableCard newModelQuery()
 * @method static Builder|UserRechargeableCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard onlyTrashed()
 * @method static Builder|UserRechargeableCard query()
 * @method static bool|null restore()
 * @method static Builder|UserRechargeableCard whereAmount($value)
 * @method static Builder|UserRechargeableCard whereCreatedAt($value)
 * @method static Builder|UserRechargeableCard whereId($value)
 * @method static Builder|UserRechargeableCard whereValidAt($value)
 * @method static Builder|UserRechargeableCard whereInvalidAt($value)
 * @method static Builder|UserRechargeableCard whereIsAutoRenew($value)
 * @method static Builder|UserRechargeableCard whereOrderId($value)
 * @method static Builder|UserRechargeableCard whereRechargeableCardId($value)
 * @method static Builder|UserRechargeableCard whereStatus($value)
 * @method static Builder|UserRechargeableCard whereUpdatedAt($value)
 * @method static Builder|UserRechargeableCard whereUserId($value)
 * @method static Builder|UserRechargeableCard whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard withoutTrashed()
 * @mixin \Eloquent
 */
class UserRechargeableCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'customer_id', 'rechargeable_card_id', 'order_id', 'amount', 'valid_at', 'invalid_at', 'is_auto_renew', 'status'
    ];

    protected $casts = [
        'is_auto_renew' => 'boolean'
    ];

    protected $dates = ['invalid_at', 'valid_at'];

    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;
    const STATUS_AUTO_INVALID = 3;
    const STATUS = [
        self::STATUS_VALID => '有效',
        self::STATUS_INVALID => '失效',
        self::STATUS_AUTO_INVALID => '自动失效'
    ];

    // 所属订单
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // 所属会员
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 所属用户
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function rechargeableCard(): BelongsTo
    {
        return $this->belongsTo(RechargeableCard::class, 'rechargeable_card_id');
    }

    // 状态中文描述
    public function getStatusDescAttribute(): string
    {
        return self::STATUS[$this->status];
    }
}