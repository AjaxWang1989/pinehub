<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/9
 * Time: 16:23
 */

namespace App\Providers;


use App\Http\Middleware\SetPaymentConfig;
use Illuminate\Support\ServiceProvider;

class MiniProgramServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application|\Laravel\Lumen\Application
     */
    protected $app = null;

    public function register()
    {
        $this->app->routeMiddleware([
            'setPaymentConfig' => SetPaymentConfig::class
        ]);
    }
}