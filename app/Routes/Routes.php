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

    protected $prefix = '';

    protected $domain = '';

    protected $version = null;

    protected $app = null;

    public function __construct(Application $app, $version = null, $namespace = null, $prefix =null, $domain = null)
    {
        $this->app = $app;
        $this->namespace = $namespace;
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

        if($this->namespace){
            $second['namespace'] = $this->namespace;
        }

        if($this->domain){
            $second['domain'] = $this->domain;
        }
        $this->app->router->group([
            'namespace' => 'App\Http\Controllers',
        ], function () use ($second){
            $api = $this->app->make('api.router');
            $api->version($this->version, $second, function () use ($api){
                $this->routes($api);
            });
        });
    }

    protected function routes(Router $api){
        $self = $this;
        $api->get('/version', function (Request $request) use ($self){
            return 'web api version '.$self->version.', host domain '.$request->getHost();
        });
    }
}