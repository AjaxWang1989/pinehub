<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ShopMerdandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int $CategoryId 商品ID
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
 * @property int $categoryId 分类ID
 * @property-read \App\Entities\Category $category
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCategoryId($value)
 */
class ShopMerchandise extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id','merchandise_id','category_id','product_id','stock_num','sell_num'
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->groupBy('id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function shop():BelongsTo
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }
}
