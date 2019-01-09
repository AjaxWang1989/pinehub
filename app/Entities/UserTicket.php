<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Entities\UserTicket
 *
 * @property int $id
 * @property string $cardId 优惠券id
 * @property string $cardCode 优惠券编码
 * @property int $userId 会员id
 * @property int $status 0-不可用，1-可用，2-已使用，3-过期
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property \Illuminate\Support\Carbon|null $beginAt
 * @property \Illuminate\Support\Carbon|null $endAt
 * @property-read \App\Entities\Card $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUserId($value)
 * @mixin \Eloquent
 */
class UserTicket extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'card_info' => 'json',
        'begin_at' => 'date',
        'end_at' => 'date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id', 'card_code', 'user_id', 'status', 'begin_at', 'end_at'
    ];

    public function tickets():BelongsTo
    {
        return $this->BelongsTo(Card::class,'card_id','card_id');
    }

}
