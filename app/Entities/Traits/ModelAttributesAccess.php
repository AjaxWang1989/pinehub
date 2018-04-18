<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/16
 * Time: 上午9:28
 */

namespace App\Entities\Traits;


trait ModelAttributesAccess
{
    public function __get($name)
    {
        // TODO: Implement __get() method.
        $key = upperCaseSplit($name, '_');
        return $this->getAttributeValue($key) ?? $this[$key] ;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->setAttribute(upperCaseSplit($name, '_'), $value);
    }
}