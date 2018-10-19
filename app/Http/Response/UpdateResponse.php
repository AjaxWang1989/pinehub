<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/24
 * Time: 下午5:18
 */

namespace App\Http\Response;


use Illuminate\Contracts\Support\Arrayable;

class UpdateResponse implements Arrayable
{
    protected $content = [];

    public function __construct($content)
    {
        $this->content['data'] = $content;
    }

    public function content()
    {
        return $this->content;
    }
    public function toArray()
    {
        // TODO: Implement toArray() method.
        return $this->content;
    }
}