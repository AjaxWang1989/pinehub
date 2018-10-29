<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Country
 *
 * @property int $id
 * @property string $code 国家或者地区编码区号
 * @property string $name 国家或者地区名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Province[] $provinces
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $table = 'countries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name'];

    public function provinces() : HasMany
    {
        return $this->hasMany(Province::class, 'country_id', 'id');
    }

    public function cities() : HasMany
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }

    public function counties() : HasMany
    {
        return $this->hasMany(County::class, 'country_id', 'id');
    }

    public function shops() : HasMany
    {
        return $this->hasMany(Shop::class, 'country_id', 'id');
    }
}
