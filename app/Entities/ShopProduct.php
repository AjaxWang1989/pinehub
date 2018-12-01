<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\ShopProduct
 *
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int|null $skuProductId sku单品ID
 * @property int $stockNum 库存
 * @property int $sellNum 销量
 * @property int $status 1-上架 0-下架
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopProduct extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id', 'merchandise_id', 'sku_product_id', 'stock_num', 'sell_num', 'status'
    ];

    public function shop() : BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function skuProduct() : BelongsTo
    {
        return $this->belongsTo(SKUProduct::class, 'sku_product_id', 'id');
    }
}
