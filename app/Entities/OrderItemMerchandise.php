<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderItemMerchandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int|null $buyerUserId 买家ID
 * @property int $orderId 订单id
 * @property int $orderItemId 子订单id
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItemMerchandise extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
