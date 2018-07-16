<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * App\Entities\Shop
 *
 * @property int $id
 * @property string|null $code 餐车编号
 * @property string|null $name 店铺名称
 * @property int $userId 店铺老板用户id
 * @property string $countryId 国家id
 * @property int $provinceId 省份id
 * @property int $cityId 城市id
 * @property int $countyId 所属区县id
 * @property string|null $address 详细地址
 * @property mixed|null $position 店铺定位
 * @property string|null $description 店铺描述
 * @property string|null $geoHash 位置hash编码
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
 * @property string|null $appId 系统app id
 * @property string|null $wechatAppId 微信app ID
 * @property string|null $aliAppId 支付宝app ID
 * @property string|null $mtAppId 美团app id
 * @property string|null $wechatParamsQrcodeUrl 微信参数二维码url
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\County $county
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\Province $province
 * @property-read \App\Entities\User $shopManager
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop comparison($geometryColumn, $geometry, $relationship)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop contains($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop crosses($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop disjoint($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distance($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphereValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop doesTouch($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop equals($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop intersects($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop overlaps($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereGeoHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereMtAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereName($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereWechatAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereWechatParamsQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop within($geometryColumn, $polygon)
 * @mixin \Eloquent
 */
class Shop extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess, SpatialTrait;

    /**
     * @var Collection
     * */
    protected $orderList = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'country_id', 'province_id', 'city_id', 'county_id', 'address', 'position', 'total_amount', 'today_amount',
        'total_off_line_amount', 'today_off_line_amount', 'total_ordering_amount', 'today_ordering_amount', 'total_ordering_num',
        'today_ordering_num', 'total_order_write_off_num', 'total_order_write_off_num', 'total_order_write_off_amount',
        'total_order_write_off_amount', 'status', 'geo_hash', 'description', 'code', 'app_id', 'wechat_app_id', 'name', 'ali_app_id',
        'mt_app_id'
    ];

    protected $spatialFields = [
        'position'
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

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_id', 'id');
    }

    public function orders() : BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items', 'shop_id', 'order_id');
    }

    public function waitWriteOffCustomers()
    {
        return $this->orders && $this->orders->count() > 0 ? $this->orders->where('status', Order::PAID)
                   ->pluck('customer_id,') : null;
    }
}
