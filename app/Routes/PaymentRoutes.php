<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/17
 * Time: 下午4:26
 */

namespace App\Routes;


class PaymentRoutes extends WebRoutes
{
    protected function subRoutes($router)
    {
        $router->get('/aggregate.html', ['as' => 'aggregate.payment', 'uses' => 'PaymentController@aggregate']);
        $router->get('/ali/aggregate.html', ['as' => 'aggregate.ali.payment.get', 'uses' => 'AliPaymentController@aggregatePage']);
        $router->get('/wechat/aggregate.html', ['as' => 'aggregate.wechat.payment.get', 'uses' => 'WechatPaymentController@aggregatePage']);

        $router->any( '/ali/notify', ['as' => 'ali.payment.notify', 'uses' => 'AliPaymentController@notify']);
        $router->any( '/wechat/notify', ['as' => 'wechat.payment.notify', 'uses' => 'WechatPaymentController@notify']);
    }
}