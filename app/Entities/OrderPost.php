<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderPost.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int|null $buyerUserId 买家ID
 * @property int $orderId 订单id
 * @property int $orderItemId 子订单id
 * @property string|null $postNo 物流订单号
 * @property string|null $postCode 收货地址邮编
 * @property string|null $postName 物流公司名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderPost extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
