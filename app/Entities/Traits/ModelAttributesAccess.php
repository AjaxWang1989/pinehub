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
        if(($value = $this->getAttributeValue($name)) || ($value = $this[$name])){
            return $value;
        }
        $key = upperCaseSplit($name, '_');
        return $this->getAttributeValue($key) ?? $this[$key] ;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->setAttribute(upperCaseSplit($name, '_'), $value);
    }

    public function formJson($value)
    {
        if(is_string($value)) {
            return parent::formJson($value);
        }elseif (is_array($value)) {
            return $value;
        }elseif (is_object($value)) {
            $json = [];
            foreach ($value as $key => $v) {
                $json[$key] = $v;
            }
            return $json;
        }
        return null;
    }
}