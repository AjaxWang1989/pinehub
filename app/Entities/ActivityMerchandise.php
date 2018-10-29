<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ActivityMerchandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $activityId 活动ID
 * @property int|null $shopId 店铺活动时显示的店铺ID
 * @property int|null $shopMerchandiseId 店铺活动时显示的店铺产品ID
 * * @property float $sellPrice 售价
 * @property int $merchandiseId 产品ID
 * @property int|null $productId sku单品ID
 * @property int $stockNum 参与活动的数量:-1无限制，大于0参与活动商品数量，0售罄
 * @property int $sellNum  售出数量
 * @property string|null $tags 产品标签
 * @property string|null $describe 产品介绍
 * @property string|null $startAt 开售时间
 * @property string|null $endAt 结业时间
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Merchandise[] $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereDescribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereTags($value)
 */
class ActivityMerchandise extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id','shop_id','shop_merchandise_id','merchandise_id','product_id','stock_num','sell_num',
        'start_at','end_at','tags','describe','sell_price'
    ];

    public function merchandise() : hasMany
    {
        return $this->hasMany(Merchandise::class, 'merchandise_id', 'id');
    }
}
