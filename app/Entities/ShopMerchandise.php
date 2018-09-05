<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ShopMerdandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int|null $productId sku单品ID
 * @property int $stockNum 库存数量
 * @property int $sellNum 销售数量
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopMerchandise extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
