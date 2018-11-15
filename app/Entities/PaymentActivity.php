<?php
namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\PaymentActivity
 *
 * @property int $id
 * @property int $activityId 活动ID
 * @property string $type 支付活动方式：满减送 PAY_FULL/支付礼包 PAY_GIFT
 * @property int|null $ticketId 优惠券id
 * @property int $ticketCount 优惠券数量
 * @property float $discount 折扣
 * @property float $cost 抵用金额
 * @property float $leastAmount 最低消费
 * @property int $score 积分
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Activity $activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereLeastAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentActivity extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const PAY_FULL = "PAY_FULL";
    const PAY_GIFT = "PAY_GIFT";

    const TYPES = [
        'coupon' => self::PAY_FULL,// up to cut 满减、
        'gift' => self::PAY_GIFT
    ];
    const WAIT = 0;
    const RUNNING = 1;
    const END = 2;
    const INVALID = 3;

    protected $dates = [
        'begin_at',
        'end_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id','type','ticket_id','discount','cost','least_amount','score', 'ticket_count'];

    public function activity() :BelongsTo
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
//    public function tickets()
//    {
//        $tickets = [];
//        foreach ($this->gift as $gift) {
//            $tickets[] = $gift['ticket_id'];
//        }
//        $tickets = Ticket::whereIn('id', $tickets)->get();
//        return $tickets;
//    }
}
