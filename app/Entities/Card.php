<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Card
 *
 * @property int $id
 * @property string $cardId 卡券id
 * @property string|null $wechatAppId 微信app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property string $cardType 卡券类型
 * @property mixed $cardInfo 卡券信息
 * @property int $status 0-审核中 1-审核通过 2-审核未通过
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereWechatAppId($value)
 * @mixin \Eloquent
 */
class Card extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    //'member_card','coupon_card','discount','groupon','gift'
    const MEMBER_CARD = 'member_card';
    const COUPON_CARD = 'coupon_card';
    const DISCOUNT = 'discount';
    const GROUPON = 'groupon';
    const GIFT = 'gift';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
