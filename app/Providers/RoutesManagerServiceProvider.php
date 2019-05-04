<?php

namespace App\Providers;

use AlbertCht\Form\FormRequestServiceProvider;
use App\Exceptions\GatewayNotAllowed;
use Illuminate\Routing\Router;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Dingo\Api\Provider\LumenServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Zoran\JwtAuthGuard\JwtAuthGuardServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Illuminate\Http\Request;

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

    protected $host = null;

    protected $gateway = null;

    protected $prefix = null;

    protected $request = null;

    protected $www = '';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

    }

    public function register()
    {
        $this->request = Request::capture();
        $this->host = $this->request->getHost();
        if(preg_match(IP_REGEX, $this->host)) {
            exit('不能直接使用ip访问本站的！');
        }
        list( $www, $gateway, $prefix) = domainAndPrefix($this->request);
        $this->prefix  = $prefix;
        $this->gateway = $gateway;
        $this->www = $www;


        Log::info('----------- api gateway -------------', [$this->gateway]);
        if(!$this->app->make('api.gateways')->has($this->gateway) && !$this->app->make('web.gateways')->has($this->gateway) && !$this->app->runningInConsole()) {
            throw new GatewayNotAllowed('网关错误');
        }
        $this->app['isApiServer'] = $this->app->make('api.gateways')->has($this->gateway);
        $this->app->register(ExcelServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(JwtAuthGuardServiceProvider::class);
        $this->registerRouter();
        $this->registerServices();
        
        $this->registerRoutes();
    }

    protected function registerServices()
    {
        if($this->app['isApiServer'] || $this->app->runningInConsole()) {
            $this->app->singleton('request', function (){
                return \Dingo\Api\Http\Request::createFrom($this->request);
            });

            $this->app->register(LumenServiceProvider::class);
            $this->app->register(ApiExceptionHandlerServiceProvider::class);
            $this->app->register(ApiAuthServiceProvider::class);
            $this->app->routeMiddleware([
                'cross' => \App\Http\Middleware\Cross::class,
                'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
                'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class
            ]);

        }

        if(!$this->app['isApiServer'] || $this->app->runningInConsole()){
            // 注册 SessionServiceProvider
            //
            $this->app->register(SessionServiceProvider::class);
            $this->app->register(FormRequestServiceProvider::class);
            $this->app->bind(SessionManager::class, function ($app){
                return $app->make('session');
            });

            $this->app->configure('session');
            $this->app->middleware([
                StartSession::class,
                AuthenticateSession::class
            ]);

            $this->app->singleton('request', function (){
                return $this->request;
            });
        }
    }


    /**
     * Register the router instance.
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('web.router', function ($app) {
            return new Router($app['events'], $app);
        });
    }

    protected function registerRoutes()
    {
        $version = app('request') instanceof \Dingo\Api\Http\Request ? app('request')->version() : null;
        foreach (config('routes') as $route) {
            if($this->gateway === gateway($route['gateway']) && ($version === null || $version === $route['version'])) {
                $prefix = isset($route['prefix']) ? $route['prefix'] : null ;
                $auth = isset($route['auth']) ? $route['auth'] : null ;
                $domain = $this->www.$this->gateway;
                if(isset($route['provider']) && $route['provider']) {
                    $this->app->register($route['provider']);
                }
                Log::debug('------- router class --------', [$route['gateway'], app('request')->path()]);
                if($auth){
                    $routes = new $route['router']($this->app, $route['version'], $route['namespace'], $prefix, $domain, $auth);
                }else{
                    $routes = new $route['router']($this->app, $route['version'], $route['namespace'], $prefix, $domain);
                }

                $routes->load();
            }
        }
    }

    protected function routeExceptionHandle() {
        $this->app;
    }
}
