<?php

namespace App\Excel;

/**
 * Class GeneratorFactory
 *
 * @package App\Excel
 */
class GeneratorFactory
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