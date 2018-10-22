<?php
namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\OrderGift
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderGift whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderGift extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const PAY_FULL = "PAY_FULL";
    const PAY_GIFT = "PAY_GIFT";

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
    protected $fillable = ['activity_id','type','ticket_id','discount','cost','least_amount','score'];

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
