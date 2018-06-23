<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/23
 * Time: 下午4:31
 */

namespace App\Notifications\Messages;


use Illuminate\Contracts\Support\Arrayable;
use ArrayAccess;

/**
 * wechat template message struct
 * @property string $templateId
 * @property string $toUser
 * @property array []
 * */
class WechatTemplateMessage implements Arrayable, ArrayAccess
{
    protected $templateId = null;

    protected $toUser = null;

    protected $data = [];

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }
}