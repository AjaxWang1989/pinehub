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

class WebRoutes extends Routes
{
    public function __construct(Application $app, $version = null, $namespace = null, $prefix = null, $domain = null)
    {
        parent::__construct($app, $version, $namespace, $prefix, $domain);
        $this->router = $this->app->router;
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
                $test = $request->getSession()->get('test1', 0);
                if($test > 0){
                    $test ++;
                }else{
                    $test = 1;
                }
                $request->getSession()->put('test1', $test);
                return "webbanch {$test}";
            });
        });
    }
}