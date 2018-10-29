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
 * @property int $activityId 活动id
 * @property int ticketId 优惠券id
 * @property string|null $discount 折扣
 * @property string|null $cost 抵用金额
 * @property string|null $leastAmount 最低消费
 * @property int  $score 积分
 * @property string $type 支付活动方式：满减送 PAY_FULL/支付礼包 PAY_GIFT
 * @property \Carbon\Carbon $beginAt 开始时间
 * @property \Carbon\Carbon $endAt 结束时间
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Entities\Activity $activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereLeastAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereTicketId($value)
 */
class PaymentActivity extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const PAY_FULL = "PAY_FULL";
    const PAY_GIFT = "PAY_GIFT";

    const TYPES = [
        'utc' => self::PAY_FULL,// up to cut 满减、
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

    protected $table = 'payment_activity';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id','type','ticket_id','discount','cost','least_amount','score'];

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
