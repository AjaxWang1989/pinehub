<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午4:44
 */

namespace App\Services\TemplateParser;

use Illuminate\Support\Facades\Log;

abstract class BaseParser implements Parser
{
    public function parse(&$data)
    {
        foreach ($data as $key => $item) {
            $value = preg_replace_callback('/\{[a-zA-Z]+\}/', function ($item) {
                $method = substr($item[0], 1, -1);
                Log::info('匹配值：', [$item, $method]);
                return method_exists($this, $method) ? $this->$method() : $method;
            }, $item['value']);
            Log::info('转换后值:', [$value]);
            $item['value'] = $value;
        }
    }
}