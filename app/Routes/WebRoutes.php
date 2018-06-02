<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/17
 * Time: 下午3:53
 */

namespace App\Routes;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Lumen\Application;

class WebRoutes extends Routes
{
    public function __construct(Application $app, $version = null, $namespace = null, $prefix = null, $domain = null)
    {
        parent::__construct($app, $version, $namespace, $prefix, $domain);
        $this->router = $this->app->router;
        //$this->app->router = $this->router;
        //$this->app->setDispatcher($this->router->events);
    }

    protected function routesRegister()
    {
        $second = [];
        if($this->prefix){
            $second['prefix'] = $this->prefix;
        }

        if($this->domain){
            $second['domain'] = $this->domain;
        }

        if($this->namespace){
            $second['namespace']  = $this->namespace.($this->subNamespace ? $this->subNamespace : '');
        }
        $this->router->group($second, function ($router){
            $this->subRoutes($router);
            $router->get('/webbanch', function (Request $request){
                $session = app('session');
                $test = $session->get('test1', null);
                if($test > 0){
                    $test ++;
                }else{
                    $test = 1;
                }
                app('session.store')->put('test1', $test);
                return "webbanch {$test}";
            });
        });
    }

    protected function subRoutes($router)
    {
        $router->addRoute(['GET', 'POST'], '/wechat/serve', 'Wechat/MessageServerController@serve');
    }
}