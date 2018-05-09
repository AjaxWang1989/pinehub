<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/28
 * Time: 上午10:41
 */

namespace App\Routes;


use Dingo\Api\Routing\Router;

trait CommonRoutes
{
    protected function routes(Router $api)
    {
        $api->group(['middleware' => ['api.auth']], function () use($api) {

        });
    }
}