<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * Class Activity.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $appId 项目应用ID
 * @property int|null $shopId 店铺id
 * @property string $title 活动名称
 * @property string $posterImg 海报图片
 * @property string $description 详情
 * @property int $status 0 未开始 1 进行中 2 已结束
 * @property string|null $startAt 活动开始时间
 * @property string|null $endAt 活动结束时间
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity wherePosterImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const NOT_BEGINNING = 0;
    const HAVE_IN_HAND  = 1;
    const FINISHED      = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['app_id','shop_id','title','poster_img','description','start_at','end_at','status'];

}
