<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 下午12:48
 */

namespace App\Routes;


use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Router;
use Laravel\Lumen\Application;

class Routes
{
    protected $namespace = 'App\Http\Controllers';

    protected $subNamespace = null;
    protected $prefix = '';

    protected $domain = '';

    protected $version = null;

    protected $app = null;

    public function __construct(Application $app, $version = null, $namespace = null, $prefix =null, $domain = null)
    {
        $this->app = $app;
        if($namespace[0] !== '\\') {
            $namespace = '\\'.$namespace;
        }
        $this->subNamespace = $namespace;
        $this->prefix = $prefix;
        $this->domain = $domain;
        $this->version = $version;
    }

    public function load()
    {
        $second = [];
        if($this->prefix){
            $second['prefix'] = $this->prefix;
        }

        if($this->domain){
            $second['domain'] = $this->domain;
        }
        $this->app->router->group([
            //'namespace' => 'App\Http\Controllers',
        ], function () use ($second){
            $api = $this->app->make('api.router');
            $api->version($this->version, $second, function () use ($api){
                $self = $this;
                $api->get('/version', function (Request $request) use ($self){
                    return 'web api version '.$self->version.', host domain '.$request->getHost();
                });
                $namespace = $this->namespace;
                if($this->namespace){
                    $namespace = $this->namespace.($this->subNamespace ? $this->subNamespace : '');
                }

                $api->group(['namespace' => $namespace], function () use($api){
                    $this->subRoutes($api);
                });

                $namespace = $this->namespace;
                $api->group(['namespace' => $namespace], function () use($api){
                    $this->routes($api);
                });

            });
        });
    }

    protected function routes(Router $api)
    {

    }

    protected function subRoutes(Router $api)
    {
    }
}