<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/24
 * Time: 下午5:27
 */

namespace App\Http\Response;


class CreateResponse
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
}