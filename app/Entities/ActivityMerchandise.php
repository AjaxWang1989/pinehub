<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Entities\ActivityMerchandise
 *
 * @property int $id
 * @property int $activityId 活动ID
 * @property int|null $shopId 店铺活动时显示的店铺ID
 * @property int|null $shopMerchandiseId 店铺活动时显示的店铺产品ID
 * @property int $merchandiseId 产品ID
 * @property float $sellPrice 售价
 * @property int|null $productId sku单品ID
 * @property int $stockNum 参与活动的数量:-1无限制，大于0参与活动商品数量，0售罄
 * @property int $sellNum 已售出数量
 * @property array $tags 产品标签
 * @property string $describe 产品介绍
 * @property string $mainImage 活动产品图片
 * @property string|null $startAt 开售时间
 * @property string|null $endAt 结业时间
 * @property string|null $mainImage
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereDescribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityMerchandise extends Model implements Transformable
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
    protected $fillable = ['activity_id','shop_id','shop_merchandise_id','merchandise_id','product_id','stock_num','sell_num',
        'start_at','end_at','tags','describe','sell_price', 'main_image'
    ];

    public function merchandise() : BelongsTo
    {
        return $this->BelongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function category ()
    {
        return $this->hasOne();
    }
}
