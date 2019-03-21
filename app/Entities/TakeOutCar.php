<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\TakeOutCar
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TakeOutCar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TakeOutCar query()
 * @mixin \Eloquent
 */
class TakeOutCar extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
