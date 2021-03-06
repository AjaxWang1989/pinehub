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
        $router->get('/material/view', ['as' => 'material.view', 'uses' => 'Admin\Wechat\MaterialController@materialView']);
        $router->get('/material/{mediaId}', ['as' => 'material.view.byId', 'uses' => 'Admin\Wechat\MaterialController@material']);
        $router->get('/shop/{id}/payment-qrcode', ['as' => 'shop.payment.qrcode', 'uses' => 'Admin\ShopsController@paymentQRCode']);
        $router->get('/shop/{id}/official-account-qrcode', ['as' => 'shop.payment.qrcode', 'uses' => 'Admin\ShopsController@officialAccountQRCode']);
    }
}