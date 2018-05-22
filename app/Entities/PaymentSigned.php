<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PaymentSigned.
 *
 * @package namespace App\Entities;
 */
class PaymentSigned implements Transformable
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
