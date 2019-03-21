<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/7/24
 * Time: 上午10:31
 */

/**
 * @var \Illuminate\Routing\Router $router
 * */
$router->get('', function (){
    echo phpinfo();
});