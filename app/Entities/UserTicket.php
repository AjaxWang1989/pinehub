<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserTicket.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $cardId 优惠券id
 * @property string $cardCode 优惠券编码
 * @property int $userId 会员id
 * @property int $status 0-不可用，1-可用，2-已使用，3-过期
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUserId($value)
 * @mixin \Eloquent
 */
class UserTicket extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
