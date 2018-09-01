<?php

namespace App\Providers;

use App\Exceptions\ApiHttpExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;


class ApiExceptionHandlerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if($this->app->has('api.exception')){
            $this->app->make('api.exception')->register(function (\Exception $exception) {
                $responseSender = new Response();
                $responseSender->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Credentials', 'true');
                if(Request::method() === HTTP_METHOD_OPTIONS) {
                    return $responseSender->send();
                }
                return $this->app->make('api.http.handler')->handle($exception);
            });
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('api.http.handler', function ($app) {
            return new ApiHttpExceptionHandler($app['Illuminate\Contracts\Debug\ExceptionHandler'], config('api.errorFormat'), config('api.debug'));
        });
    }
}
