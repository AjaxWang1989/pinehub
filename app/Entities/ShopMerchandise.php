<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Entities\ShopMerchandise
 *
 * @property int $id
 * @property int $shopId 店铺id
 * @property float $sellPrice 售价
 * @property int $merchandiseId 商品ID
 * @property int $categoryId 分类ID
 * @property array $tags 标签
 * @property int|null $productId sku单品ID
 * @property int $stockNum 库存数量
 * @property int $sellNum 销售数量
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Category $category
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopMerchandise extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'tags' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id','merchandise_id','category_id','product_id','stock_num','sell_num','sell_price', 'tags'
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

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'merchandise_categories',
            'merchandise_id', 'category_id');
    }
}
