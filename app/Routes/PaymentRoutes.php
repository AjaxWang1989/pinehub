<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/17
 * Time: 下午4:26
 */

namespace App\Routes;


use Laravel\Lumen\Routing\Router;

class PaymentRoutes extends WebRoutes
{
    protected function subRoutes($router)
    {
        tap($router, function (Router $router) {
            $router->get('/aggregate.html', ['as' => 'aggregate.payment', 'uses' => 'PaymentController@aggregate']);
            $router->get('/ali/aggregate.html', ['as' => 'aggregate.ali.payment.get', 'uses' => 'AliPaymentController@aggregatePage']);
            $router->get('/wechat/aggregate.html', ['as' => 'aggregate.wechat.payment.get', 'uses' => 'WechatPaymentController@aggregatePage']);
            $router->get('store/{storeId}/mp/aggregate', ['as' => 'aggregate.payment', 'uses' => 'PaymentController@mpAggregate']);
            $router->addRoute(['GET', 'POST'], '/ali/notify', ['as' => 'ali.payment.notify', 'uses' => 'AliPaymentController@notify']);
            $router->addRoute(['GET', 'POST'], '/wechat/notify', ['as' => 'wechat.payment.notify', 'uses' => 'WechatPaymentController@notify']);
        });
    }
}