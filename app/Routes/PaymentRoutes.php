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
        $router->get('/aggregate/payment', ['as' => 'aggregate.payment', 'uses' => 'PaymentController@aggregate']);
        $router->get('/ali/aggregate/payment', ['as' => 'aggregate.ali.payment.get', 'uses' => 'AliPaymentController@aggregate']);
        $router->get('/wechat/aggregate/payment', ['as' => 'aggregate.wechat.payment.get', 'uses' => 'WechatPaymentController@aggregate']);
    }
}