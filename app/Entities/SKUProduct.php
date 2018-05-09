<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\SKUProduct
 *
 * @property int $id
 * @property int $merchandiseId 产品id
 * @property string $code 规格产品编码
 * @property array $images 图片数组
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价格
 * @property float $factoryPrice 工厂价格
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereFactoryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SKUProduct extends Model implements Transformable
{
    use TransformableTrait;

    protected $casts = [
        'images' => 'array'
    ];
    protected $table = 's_k_u_products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'main_image', 'images', 'origin_price', 'cost_price', 'sell_price', 'factory_price',
        'stock_num', 'sell_num', 'status', 'merchandise_id'
    ];

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function shops() : BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'shop_products', 'sku_product_id', 'shop_id');
    }
}
