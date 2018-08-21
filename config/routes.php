<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/8/21
 * Time: 下午2:02
 */
return [
    [
        'gateway' => 'api.auth',
        'router' => \App\Routes\AuthApiRoutes::class,
        'version' => 'v1',
//        'prefix' => null,
        'namespace' => 'Auth'
    ]
];