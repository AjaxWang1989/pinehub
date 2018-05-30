<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 下午12:48
 */

namespace App\Routes;


use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Router as DingoRouter;
use Laravel\Lumen\Routing\Router as LumenRouter;
use Laravel\Lumen\Application;

class Routes
{
    protected $namespace = 'App\Http\Controllers';

    protected $subNamespace = null;

    protected $prefix = '';

    protected $domain = '';

    protected $version = null;

    /**
     *@var Application $app
     * */
    protected $app = null;

    /**
     * @var LumenRouter|DingoRouter $router
     * */
    protected $router = null;

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
        $this->boot();
        $this->app->router->group([
            //'namespace' => 'App\Http\Controllers',
            //'middleware' => 'cross'
        ], function () {
            $this->routesRegister();
        });
    }

    protected function routesRegister()
    {

    }

    protected function boot()
    {

    }



    /**
     * @param DingoRouter|LumenRouter $router
     * */
    protected function subRoutes($router)
    {

    }

    public function domain()
    {
        return $this->domain;
    }

    public function prefix()
    {
        return $this->prefix;
    }

    public function router()
    {
        return $this->router;
    }
}