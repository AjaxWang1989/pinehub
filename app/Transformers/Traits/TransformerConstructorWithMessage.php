<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/8
 * Time: 上午10:54
 */

namespace App\Transformers\Traits;


trait TransformerConstructorWithMessage
{
    protected $message = null;

    public function __construct($message = '')
    {
        $this->message = $message;
    }
}