<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * App\Entities\Activity
 *
 * @property int $id
 * @property string $appId 项目应用ID
 * @property string $type 活动类型
 * @property int|null $shopId 店铺id
 * @property string $title 活动名称
 * @property string $posterImg 海报图片
 * @property string $description 详情
 * @property int $status 0 未开始 1 进行中 2 已结束
 * @property string|null $startAt 活动开始时间
 * @property string|null $endAt 活动结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\PaymentActivity[] $paymentActivities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity wherePosterImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const NOT_BEGINNING = 0;
    const HAVE_IN_HAND  = 1;
    const FINISHED      = 2;
    const INVALID = 3;

    const NEW_PRODUCT_ACTIVITY = 'NEW_PRODUCT';
    const PAY_FULL = "PAY_FULL";
    const PAY_GIFT = "PAY_GIFT";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'shop_id',
        'type',
        'title',
        'poster_img',
        'description',
        'start_at',
        'end_at',
        'status'
    ];

    public function paymentActivities():HasMany
    {
        return $this->hasMany(PaymentActivity::class, 'activity_id', 'id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'activity_id', 'id');
    }

    public function customers() : BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'orders', 'activity_id', 'customer_id');
    }

}
