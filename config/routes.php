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
    ],
    [
        'gateway' => 'api.backend',
        'router' => \App\Routes\BackendApiRoutes::class,
        'version' => 'v1',
//        'prefix' => null,
        'namespace' => 'Admin'
    ],
    [
        'gateway' => 'api.mp',
        'router' => \App\Routes\MiniProgramApiRoutes::class,
        'version' => 'v1',
//        'prefix' => null,
        'namespace' => 'MiniProgram',
        'auth' => 'mp'
    ],
    [
        'gateway' => 'api.h5',
        'router' => \App\Routes\AuthApiRoutes::class,
        'version' => 'v1',
//        'prefix' => null,
        'namespace' => 'Auth'
    ],
//    [
//        'gateway' => 'api.auth',
//        'router' => \App\Routes\TestApiRoutes::class,
//        'version' => 'v1',
//        'namespace' => 'Test'
//    ]

];