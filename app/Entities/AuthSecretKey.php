<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/10
 * Time: 下午2:53
 */

namespace App\Entities;


/**
 * class AuthSecretKey
 * @property-read $publicKey
 * @property-read $privateKey
 * */
class AuthSecretKey
{
    private $publicKey = "";

    private $privateKey = "";

    public function __construct()
    {
        $this->privateKey = config('app.private_key');
        $this->publicKey = config('app.public_key');
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->{$name};
    }
}