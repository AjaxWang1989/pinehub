<?php

namespace App\Providers;

use App\Routes\WebRoutes;
use Dingo\Api\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RoutesManagerServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application|\Laravel\Lumen\Application
     */
    protected $app = null;
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if(!$this->app->runningInConsole()){
            $this->map();
        }

    }

    /**
     * @throws
     * */
    protected function map()
    {
        $domains = explode('.', $_SERVER['HTTP_HOST']);
        switch ($domains[1]){
            case 'web':{
                new WebRoutes();
                break;
            }
        }
    }
}
