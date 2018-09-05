<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ActivityMerchandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $activityId 活动ID
 * @property int|null $shopId 店铺活动时显示的店铺ID
 * @property int|null $shopMerchandiseId 店铺活动时显示的店铺产品ID
 * @property int $merchandiseId 产品ID
 * @property int|null $productId sku单品ID
 * @property int $stockNum 参与活动的数量:-1无限制，大于0参与活动商品数量，0售罄
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
 * @mixin \Eloquent
 */
class ActivityMerchandise extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
