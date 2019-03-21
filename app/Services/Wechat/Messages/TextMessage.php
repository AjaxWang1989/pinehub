<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/5
 * Time: 下午2:34
 */

namespace App\Services\Wechat\Messages;


use Carbon\Carbon;

class TextMessage implements \ArrayAccess
{
    protected $message = [];

    public function __construct(string  $to, string $from, Carbon $createTime, string $message)
    {
        $this->message['ToUserName'] = $to;
        $this->message['FromUserName'] = $from;
        $this->message['CreateTime'] = $createTime->timestamp;
        $this->message['MgsType'] = WECHAT_TEXT_MESSAGE;
        $this->message['Content'] = $message;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        return isset($this->message[$offset]);
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        return $this->message[$offset];
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        $this->message[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
        unset($this->message[$offset]);
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return json_encode($this->message);
    }
}