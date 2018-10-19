<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Administrator.
 *
 * @package namespace App\Entities;
 */
class Administrator extends User
{
    protected $table = 'users';
}
