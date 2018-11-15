<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Merchandise
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $code 产品编号
 * @property string $name 产品名称
 * @property string $mainImage 主图
 * @property array $images 轮播图数组
 * @property string $preview 简介
 * @property string $detail 详情
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价格
 * @property float $factoryPrice 工厂价格
 * @property int $capacity 产能（工厂生产能力）
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\SKUProduct[] $skuProducts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereFactoryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Merchandise extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const UP = 1;
    const DOWN = 0;

    protected $casts = [
        'images' => 'array',
        'tags' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'main_image', 'images', 'preview', 'detail', 'origin_price', 'cost_price', 'sell_price', 'factory_price',
        'stock_num', 'sell_num', 'status', 'capacity'
    ];

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class, 'merchandise_id', 'id');
    }

    public function shops() : BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'shop_products', 'merchandise_id', 'shop_id');
    }

    public function skuProducts() : HasMany
    {
        return $this->hasMany(SKUProduct::class, 'merchandise_id', 'id');
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'merchandise_categories',
            'merchandise_id', 'category_id');
    }
}
