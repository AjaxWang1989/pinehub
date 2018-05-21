<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WechatPaymentSigned.
 *
 * @package namespace App\Entities;
 */
class WechatPaymentSigned implements Transformable
{
    use TransformableTrait;

    protected $data = null;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function data()
    {
        return $this->data;
    }
}
