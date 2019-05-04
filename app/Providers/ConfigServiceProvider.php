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
        foreach ([
            'app',
            'auth',
            'jwt',
            'ide-helper',
            'repository',
            'ali',
            'filesystems',
            'session',
            'database',
            'order',
            'queue',
            'broadcasting',
            'cache',
            'logging',
            'view',
            'gateway',
            'wechat',
            'routes',
            'laravel-baidu-speech'
                 ] as $name){
            laravelToLumen($this->app)->configure($name);
        }
        var_dump(config('cache'));exit();
    }
}