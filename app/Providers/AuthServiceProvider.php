<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Dingo\Api\Auth\Provider\Basic as DingoBasic;
use Dingo\Api\Auth\Provider\JWT as DingoJWT;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

//        $this->app['auth']->viaRequest('api', function ($request) {
//            if ($request->input('api_token')) {
//                return User::where('api_token', $request->input('api_token'))->first();
//            }
//        });

        //dingo auth HTTP Basic
//        app('api.auth')->extend('basic', function ($app) {
//            return new DingoBasic($app['auth'], 'mobile');
//        });

        //dingo auth JSON Web Tokens (JWT)
        app('api.auth')->extend('jwt', function ($app) {
            return new DingoJWT($app['Tymon\JWTAuth\JWTAuth']);
        });

        //dingo auth OAuth 2.0
    }
}
