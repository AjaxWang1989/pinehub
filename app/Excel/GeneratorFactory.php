<?php

namespace App\Excel;

use App\Excel\Factory as ExcelFactory;

/**
 * Class GeneratorFactory
 *
 * @package App\Excel
 */
class GeneratorFactory implements ExcelFactory
{
    /**
     * 获取Excel生成器
     * @param string $key
     * @return BaseGenerator|null
     */
    public static function getGenerator(string $key)
    {
        $generator = null;
        $generatorClass = config("generators.{$key}");
        if ($generatorClass) {
            $generator = new $generatorClass();
        }
        return $generator;
    }
}