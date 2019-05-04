<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-16
 * Time: 上午10:40
 */

namespace App\Services\TemplateParser;


interface Parser
{
    public function parse(&$data);
}