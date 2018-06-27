<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\County
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property string $code 区县编码
 * @property string $name 区县名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 */
class County extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $table = 'counties';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id', 'province_id', 'city_id', 'county_id', 'code', 'name'];

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

    public function shops() : HasMany
    {
        return $this->hasMany(Shop::class, 'county_id', 'id');
    }
}
