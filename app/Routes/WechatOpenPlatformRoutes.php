<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/28
 * Time: 下午7:25
 */

namespace App\Routes;


use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Routing\Router;

class WechatOpenPlatformRoutes extends WebRoutes
{
    protected function subRoutes($router)
    {
        tap($router, function (Router $router) {
            $router->get('/{appId}/auth', ['as' => 'open-platform.auth.callback', 'uses' => 'OpenPlatformController@componentLoginCallback']);
            $router->get('/auth', ['as' => 'open-platform.auth', 'uses' => 'OpenPlatformController@componentLoginAuth']);
            $router->post('/{appId}/serve', ['as' => 'open-platform.serve', 'uses' => 'OpenPlatformController@serve']);
        });
    }
}