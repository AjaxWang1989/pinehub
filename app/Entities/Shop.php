<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * App\Entities\Shop
 *
 * @property int $id
 * @property int $userId 店铺老板用户id
 * @property int $countryId 国家id
 * @property int $provinceId 省份id
 * @property int $cityId 城市id
 * @property int $countyId 所属区县id
 * @property string|null $address 详细地址
 * @property mixed|null $position 店铺定位
 * @property float $totalAmount 店铺总计营业额
 * @property float $todayAmount 今日营业额
 * @property float $totalOffLineAmount 店铺预定总计营业额
 * @property float $todayOffLineAmount 今日线下营业额
 * @property float $totalOrderingAmount 店铺总计营业额
 * @property float $todayOrderingAmount 今日预定营业额
 * @property int $todayOrderingNum 今日预定订单数量
 * @property int $totalOrderingNum 店铺自提系统一共预定单数
 * @property int $todayOrderWriteOffAmount 今日核销订单营业额
 * @property int $totalOrderWriteOffAmount 店铺自提系统一共核营业额
 * @property int $todayOrderWriteOffNum 今日核销订单数量
 * @property int $totalOrderWriteOffNum 店铺自提系统一共核销单数
 * @property int $status 状态：0-等待授权 1-营业中 2-休业 3-封锁店铺
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\County $county
 * @property-read \App\Entities\Province $province
 * @property-read \App\Entities\User $shopManager
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOffLineAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderWriteOffAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderWriteOffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderingNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOffLineAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderWriteOffAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderWriteOffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderingNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereUserId($value)
 * @mixin \Eloquent
 */
class Shop extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'country_id', 'province_id', 'city_id', 'county_id', 'address', 'position', 'total_amount', 'today_amount',
        'total_off_line_amount', 'today_off_line_amount', 'total_ordering_amount', 'today_ordering_amount', 'total_ordering_num',
        'today_ordering_num', 'total_order_write_off_num', 'total_order_write_off_num', 'total_order_write_off_amount',
        'total_order_write_off_amount', 'status'
    ];

    public function shopManager() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function province() : BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function county() : BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }
}
