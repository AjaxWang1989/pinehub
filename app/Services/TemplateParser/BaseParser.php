<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午4:44
 */

namespace App\Services\TemplateParser;

abstract class BaseParser implements Parser
{
    public function parse(&$data)
    {
        foreach ($data as $key => $item) {
            $value = preg_replace_callback('{{[a-zA-Z]+}}', function ($item) {
                $method = substr($item[0], 1, -1);
                return method_exists($this, $method) ? $this->$method() : $method;
            }, $item['value']);
            $item['value'] = $value;
        }
    }
}