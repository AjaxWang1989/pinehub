<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/8
 * Time: 上午11:04
 */

namespace App\Http\Response;


use Illuminate\Contracts\Support\Arrayable;

class DeleteResponse implements Arrayable
{
    protected $content = [];

    public function __construct($content)
    {
        $this->content = is_string($content) ? ['message' => $content] : $content;
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