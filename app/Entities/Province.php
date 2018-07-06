<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Province
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property string $code 省份编码
 * @property string $name 省份名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $countryId 国家ID
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 */
class Province extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'code', 'name'
    ];

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function cities() : HasMany
    {
        return $this->hasMany(City::class, 'province_id', 'id');
    }

    public function counties() : HasMany
    {
        return $this->hasMany(County::class, 'province_id', 'id');
    }

    public function shops() : HasMany
    {
        return $this->hasMany(Shop::class, 'province_id', 'id');
    }
}
