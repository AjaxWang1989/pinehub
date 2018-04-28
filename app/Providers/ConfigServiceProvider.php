<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/11
 * Time: 下午5:41
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register () {
        $basePath = $this->app->basePath();

        $configs = [];
        foreach ([
            'app',
            'auth',
            'jwt',
            'ide-helper',
            'repository',
            'ali',
            'wechat'
                 ] as $path){
            $configs = array_merge($configs, [$path => require_once ("{$basePath}/config/{$path}.php")]);
        }
        config($configs);
    }
}