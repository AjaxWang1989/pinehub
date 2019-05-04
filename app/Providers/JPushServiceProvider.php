<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/2/2
 * Time: 1:01 PM
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use JPush\Client as JPush;

class JPushServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('jPush', function () {
            return new JPush(config('jPush.app_key'), config('jPush.master_secret'));
        });
    }
}