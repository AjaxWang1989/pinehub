<?php

namespace App\Providers;

use App\Routes\AuthRoutes;
use App\Routes\Routes;
use App\Routes\WebRoutes;
use Dingo\Api\Http\Request;
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

    protected $routes = null;

    protected $config = [];

    protected $host = null;

    protected $domain = null;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutes();

    }

    /**
     * Load the application routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->routes = $this->app->make('api.routes');
        $this->routes->load();
    }

    public function register()
    {
        $request = Request::capture();
        $this->host = $request->getHost();
        $domains = explode('.', $this->host);
        if($domains[0] === 'www')
        {
            array_shift($domains);
        }
        $this->domain = implode('.', $domains);
        $this->registerConfig();
        $this->registerRoutes();
    }

    protected function registerConfig()
    {
        switch ($this->domain){
            case env('WEB_API_DOMAIN'): {
                $this->config = [
                    'domain' => $this->host,
                    'version' => env('WEB_API_VERSION'),
                    'prefix'  => env('WEB_API_PREFIX')
                ];
                break;
            }
            case env('AUTH_API_DOMAIN') : {
                $this->config = [
                    'domain' => $this->host,
                    'version' => env('AUTH_API_VERSION'),
                    'prefix'  => env('AUTH_API_PREFIX')
                ];
                break;
            }
        }
        if($this->domain)
            config(['api' => $this->config]);
        else
            $this->config = config('api');
    }

    protected function registerRoutes()
    {
        switch ($this->domain){
            case env('WEB_API_DOMAIN'): {
                $this->app->singleton('api.routes',function (){
                    return new WebRoutes($this->app, $this->config['version'], $this->namespace.'\Admin',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            case env('AUTH_API_DOMAIN') : {
                $this->app->singleton('api.routes',function (){
                    return new AuthRoutes($this->app, $this->config['version'], $this->namespace.'\Auth',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            default: {
                $this->app->singleton('api.routes',function (){
                    return new Routes($this->app, $this->config['version'], $this->namespace,
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
        }
    }
}
