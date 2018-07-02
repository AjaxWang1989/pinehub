<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\CustomerTicketCard
 *
 * @property int $id
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property string $appId 应用id
 * @property int $customerId 客户id
 * @property int $used 是否核销
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUsed($value)
 * @mixin \Eloquent
 */
class CustomerTicketCard extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
