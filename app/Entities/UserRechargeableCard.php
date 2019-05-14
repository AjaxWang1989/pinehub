<?php
/**
 * UserRechargeableCard.php
 * User: katherine
 * Date: 19-5-13 下午5:32
 */

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Entities\UserRechargeableCard
 *
 * @property int $id
 * @property int $userId 用户ID
 * @property int $rechargeableCardId 卡种ID
 * @property int $orderId 订单ID
 * @property int $amount 卡内余额，初始值为卡内设定余额，逾期不可用
 * @property Carbon $invalidAt 卡种失效时间
 * @property bool $isAutoRenew 是否自动续费，默认否
 * @property int $status 用户持有卡种状态 1=>有效 2=>失效
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property-read Order $order
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static Builder|UserRechargeableCard newModelQuery()
 * @method static Builder|UserRechargeableCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard onlyTrashed()
 * @method static Builder|UserRechargeableCard query()
 * @method static bool|null restore()
 * @method static Builder|UserRechargeableCard whereAmount($value)
 * @method static Builder|UserRechargeableCard whereCreatedAt($value)
 * @method static Builder|UserRechargeableCard whereId($value)
 * @method static Builder|UserRechargeableCard whereInvalidAt($value)
 * @method static Builder|UserRechargeableCard whereIsAutoRenew($value)
 * @method static Builder|UserRechargeableCard whereOrderId($value)
 * @method static Builder|UserRechargeableCard whereRechargeableCardId($value)
 * @method static Builder|UserRechargeableCard whereStatus($value)
 * @method static Builder|UserRechargeableCard whereUpdatedAt($value)
 * @method static Builder|UserRechargeableCard whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserRechargeableCard withoutTrashed()
 * @mixin \Eloquent
 */
class UserRechargeableCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'rechargeable_card_id', 'order_id', 'amount', 'invalid_at', 'is_auto_renew', 'status'
    ];

    protected $casts = [
        'is_auto_renew' => 'boolean'
    ];

    protected $dates = ['invalid_at'];

    // 所属订单
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // 所属用户
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}