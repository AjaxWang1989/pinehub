<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\City
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property string $code 城市编码
 * @property string $name 城市名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $table = 'cities';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'province_id', 'city_id', 'code', 'name'
    ];

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function province() : BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function counties() : HasMany
    {
        return $this->hasMany(County::class, 'city_id', 'id');
    }

    public function shops() : HasMany
    {
        return $this->hasMany(Shop::class, 'city_id', 'id');
    }
}
