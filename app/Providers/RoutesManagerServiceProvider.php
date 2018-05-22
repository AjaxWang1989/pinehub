<?php

namespace App\Providers;

use App\Routes\AuthApiRoutes;
use App\Routes\MiniProgramApiRoutes;
use App\Routes\OauthRoutes;
use App\Routes\PaymentApiRoutes;
use App\Routes\PaymentRoutes;
use App\Routes\Routes;
use App\Routes\WebApiRoutes;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Dingo\Api\Provider\LumenServiceProvider;
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

    protected $routes = null;

    protected $config = [];

    protected $host = null;

    protected $domain = null;

    protected $loaded = false;

    protected $prefix = null;

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
        if(!$this->loaded){
            $this->routes = $this->app->make('app.routes');
            $this->routes->load();
            $this->loaded = true;
        }

    }

    public function register()
    {
        $request = Request::capture();
        $this->host = $request->getHost();
        list( $domain, $prefix) = domainAndPrefix($request);
        Log::debug("domain {$domain}, prefix {$prefix} url {$request->fullUrl()}");
        $this->prefix = $prefix;
        $this->domain = $domain;
        $this->registerServices();
        $this->registerConfig();
        $this->registerRoutes();
    }

    protected function registerServices()
    {
        $this->app['isApiServer'] = in_array($this->domain, [env('WEB_API_DOMAIN'), env('AUTH_API_DOMAIN'),
            env('MP_API_DOMAIN'), env('PAYMENT_API_DOMAIN')]) ;
        if($this->app['isApiServer'] || $this->app->runningInConsole()){
            $this->app->register(LumenServiceProvider::class);
            $this->app->register(ApiExceptionHandlerServiceProvider::class);
            $this->app->register(ApiAuthServiceProvider::class);
        }

        if(!$this->app['isApiServer'] || $this->app->runningInConsole()){
            // 注册 SessionServiceProvider
            //
            $this->app->register(SessionServiceProvider::class);
            $this->app->bind(SessionManager::class, function ($app){
                return new SessionManager($app);
            });
            $this->app->middleware([
                StartSession::class,
                AuthenticateSession::class
            ]);
        }
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
            case env('MP_API_DOMAIN') : {
                $this->config = [
                    'domain' => $this->host,
                    'version' => env('MP_API_VERSION'),
                    'prefix'  => env('MP_API_PREFIX')
                ];
                break;
            }
            case env('PAYMENT_API_DOMAIN') : {
                $this->config = [
                    'domain' => $this->host,
                    'version' => env('PAYMENT_API_VERSION'),
                    'prefix'  => env('PAYMENT_API_PREFIX')
                ];
                break;
            }
            case env('WEB_DOMAIN') : {
                switch ($this->prefix) {
                    case env('WEB_PAYMENT_PREFIX'):{
                        $this->config = [
                            'domain' => $this->host,
                            'version' => env('WEB_VERSION'),
                            'prefix'  => env('WEB_PAYMENT_PREFIX')
                        ];
                        break;
                    }
                    case env('WEB_OAUTH_PREFIX'):{
                        $this->config = [
                            'domain' => $this->host,
                            'version' => env('WEB_VERSION'),
                            'prefix'  => env('WEB_OAUTH_PREFIX')
                        ];
                        break;
                    }
                }

                break;

            }
        }

        if($this->app['isApiServer']){
            if($this->domain)
                config(['api' => array_merge(config('api'), $this->config)]);
            else
                $this->config = config('api');
        }elseif($this->config){
            $app = config('app');
            $app['web_prefix'] = $this->config['prefix'];
            config([
                'app' => $app
            ]);
        }
    }

    protected function registerRoutes()
    {
        switch ($this->domain){
            case env('WEB_API_DOMAIN'): {
                $this->app->singleton('app.routes',function (){
                    return new WebApiRoutes($this->app, $this->config['version'], 'Admin',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            case env('AUTH_API_DOMAIN') : {
                $this->app->singleton('app.routes',function (){
                    return new AuthApiRoutes($this->app, $this->config['version'], 'Auth',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            case env('MP_API_DOMAIN') : {
                $this->app->singleton('app.routes',function (){
                    return new MiniProgramApiRoutes($this->app, $this->config['version'], 'MiniProgram',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            case env('PAYMENT_API_DOMAIN') : {
                $this->app->singleton('app.routes',function (){
                    return new PaymentApiRoutes($this->app, $this->config['version'], 'Payment',
                        $this->config['prefix'], $this->config['domain']);
                });
                break;
            }
            case env('WEB_DOMAIN') : {
                switch ($this->prefix){
                    case env('WEB_PAYMENT_PREFIX'):{
                        $this->app->singleton('app.routes',function (){
                            return new PaymentRoutes($this->app, $this->config['version'], 'Payment',
                                $this->config['prefix'], $this->config['domain']);
                        });
                        break;
                    }

                    case env('WEB_OAUTH_PREFIX'):{
                        $this->app->singleton('app.routes',function (){
                            return new OauthRoutes($this->app, $this->config['version'], 'Auth',
                                $this->config['prefix'], $this->config['domain']);
                        });
                        break;
                    }

                    default: {
                        $this->app->singleton('app.routes',function (){
                            return new Routes($this->app, null , null,
                                null, null);
                        });
                        break;
                    }
                }
                break;
            }
            default: {
                $this->app->singleton('app.routes',function (){
                    return new Routes($this->app, null , null,
                        null, null);
                });
                break;
            }
        }
    }

    protected function routeExceptionHandle() {
        $this->app;
    }
}
