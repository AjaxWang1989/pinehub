<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 下午12:48
 */

namespace App\Routes;


use Dingo\Api\Routing\Router;

class Routes
{
    /**
     * @Router
     * */
    protected $router = null;

    public function __construct()
    {
        $this->router = app(Router::class);
        $this->map();
    }

    protected function map()
    {
        $this->router->version(env('API_VERSION'), function (Router $router){
            $router->group(['prefix' => env('API_PREFIX')], function (Router $router){
                $this->routes($router);
            });
        });
    }

    protected function routes(Router $router){

    }
}