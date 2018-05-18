<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/17
 * Time: 下午3:58
 */

namespace App\Routes;


use Laravel\Lumen\Application;

class ApiRoutes extends Routes
{
    public function __construct(Application $app, $version = null, $namespace = null, $prefix = null, $domain = null)
    {

        parent::__construct($app, $version, $namespace, $prefix, $domain);
        $this->router = $this->app->make('api.router');
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

        $second['middleware'] = ['cross'];
        $this->router->version($this->version, $second, function ($router){
            $self = $this;
            $router->get('/version', function (Request $request) use ($self){
                return 'web api version '.$self->version.', host domain '.$request->getHost();
            });
            $namespace = $this->namespace;
            if($this->namespace){
                $namespace = $this->namespace.($this->subNamespace ? $this->subNamespace : '');
            }

            $router->group(['namespace' => $namespace], function () use($router){
                $this->subRoutes($router);
            });

            $namespace = $this->namespace;
            $router->group(['namespace' => $namespace], function () use($router){
                $this->routes($router);
            });
        });
    }

    /**
     * @param DingoRouter|LumenRouter $router
     * */
    protected function routes($router)
    {
//        $router->group(['middleware' => ['api.auth']], function () use($router){
//            $router->get("/self/info", [
//                'as' => 'self.info',
//                'uses' => 'MyselfController@selfInfo'
//            ]);
//        });
    }

    protected function boot()
    {

    }
}