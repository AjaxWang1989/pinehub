<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dingo\Api\Auth\Provider\JWT as DingoJWT;

class ApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        //dingo auth JSON Web Tokens (JWT)
        if($this->app->has('api.auth')){
            app('api.auth')->extend('jwt', function ($app) {
                return new DingoJWT($app['Tymon\JWTAuth\JWTAuth']);
            });
        }
    }
}
