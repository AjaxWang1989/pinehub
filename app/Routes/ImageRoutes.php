<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/20
 * Time: 上午11:37
 */

namespace App\Routes;


class ImageRoutes extends WebRoutes
{
    protected function subRoutes($router)
    {
        $router->get('/material/view', ['as' => 'material.view', 'uses' => 'Admin/Wechat/MaterialController@materialView']);
    }
}