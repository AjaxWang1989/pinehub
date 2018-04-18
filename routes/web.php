<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$api = app('api.router');
$api->version(env('WEB_API_VERSION'), ['prefix' => env('WEB_API_PREFIX'), 'domain' => env('API_DOMAIN'),
    'namespace' => 'App\Http\Controllers'], function () use($api){
    $api->get('/version', function (){
        //app('api.auth')->authenticate(['jwt']);
       return 'web api version '.env('WEB_API_VERSION');
    });
    $api->get('/auth',['as' => 'login', 'uses' => 'Auth\AuthController@authenticate']);
    //
    $api->group([],function () use($api){
        $api->get('/users',['as' => 'users.list', 'uses' => 'Admin\UsersController@getUsers']);
        $api->get('/user/{id}',['as' => 'user.detail', 'uses' => 'Admin\UsersController@getDetail']);
    });
});
