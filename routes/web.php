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
$api->version(env('WEB_API_VERSION'), ['prefix' => env('WEB_API_PREFIX'), 'domain' => env('API_DOMAIN')], function () use($api){
    $api->get('/version', function (){
       return 'web api version '.env('WEB_API_VERSION');
    });
});
