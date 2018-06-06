<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WechatConfig.
 *
 * @package namespace App\Entities;
 */
class WechatConfig extends Model implements Transformable
{
    use TransformableTrait;

    const GREEN_KEY_APP = 'GREEN_KEY';
    const TAKE_OUT_APP = 'TAKE_OUT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
