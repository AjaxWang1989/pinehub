<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/2
 * Time: 下午8:12
 */

namespace App\Services\AliPay;


/**
 * @property array $config
 * */
class AliPayOpenPlatform
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->{$name};
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->{$name} = $value;
    }
}