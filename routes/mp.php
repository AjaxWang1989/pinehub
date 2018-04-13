<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 下午3:26
 */
$api = app('api.router');
$api->version(env('MP_API_VERSION'), ['prefix' => env('MP_API_PREFIX'),'domain' => env('API_DOMAIN')], function () use($api){
    $api->get('/version', function (){
        return 'mini program api version '.env('MP_API_VERSION');
    });
});