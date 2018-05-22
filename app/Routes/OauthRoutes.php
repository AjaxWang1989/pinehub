<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午8:26
 */

namespace App\Routes;


class OauthRoutes extends WebRoutes
{
    protected function subRoutes($router)
    {
        $router->get('/ali', ['as' => 'oauth.ali', 'uses' => 'AliAuthController@oauth2']);
        $router->get('/wechat', ['as' => 'oauth.wechat', 'uses' => 'WechatAuthController@oauth2']);
    }
}