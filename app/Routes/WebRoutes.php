<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/17
 * Time: 下午3:53
 */

namespace App\Routes;


use Illuminate\Http\Request;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;

class WebRoutes extends Routes
{
    public function __construct(Application $app, $version = null, $namespace = null, $prefix = null, $domain = null)
    {
        parent::__construct($app, $version, $namespace, $prefix, $domain);
        $this->router = $this->app->router;
    }

    protected function routesRegister($version = null)
    {
        $second = [];
        if($this->prefix){
            $second['prefix'] = $this->prefix;
        }else{
            $second['prefix'] = $version;
        }

        if($this->domain){
            $second['domain'] = $this->domain;
        }

        if($this->namespace){
            $second['namespace']  = $this->namespace.($this->subNamespace ? $this->subNamespace : '');
        }
        $this->router->group($second, function ($router){
            /**
             * @var Router
             * */
            tap($router, function (Router $router) {
                $this->subRoutes($router);
                $router->addRoute(['GET', 'POST', 'HEADER', 'OPTION'], '/', function (Request $request) {
                    exit( 'web route v1.0.0' );
                });
            });

        });
    }

    protected function subRoutes($router)
    {
        tap($router, function (Router $router) {
            $router->addRoute(['GET', 'POST'], '/{server}/serve', 'Wechat\MessageServerController@serve');
        });

    }
}