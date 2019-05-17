<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\UserRechargeableCardConsumeRecord
 * @property int id
 * @property int $userId 用户ID
 * @property int $orderId 订单ID
 * @property int $rechargeableCardId 卡片ID
 * @property int $consume 消费金额，单位：分
 * @property int $save 节省金额，单位：分
 * @property-read Order $order 所属订单
 * @property-read User $user 所属用户
 * @property-read RechargeableCard $rechargeableCard 关联卡片
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord whereRechargeableCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserRechargeableCardConsumeRecord query()
 * @mixin \Eloquent
 */
class UserRechargeableCardConsumeRecord extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_id', 'rechargeable_card_id', 'consume', 'save'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rechargeableCard(): BelongsTo
    {
        return $this->belongsTo(RechargeableCard::class, 'rechargeable_card_id');
    }

}
