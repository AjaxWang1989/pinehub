<?php
require_once __DIR__.'/../vendor/autoload.php';

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->bind('path.config', function (){
    return __DIR__.'/../config';
});

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     \App\Http\Middleware\Cross::class
// ]);

 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
 ]);


/**
 *fix cache and auth manager bug
 * */
$app->alias('cache', 'Illuminate\Cache\CacheManager');
$app->alias('auth', 'Illuminate\Auth\AuthManager');
$app->alias('tymon.jwt', \Tymon\JWTAuth\JWTAuth::class);
$app->alias('Storage', \Illuminate\Support\Facades\Storage::class);
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
 $app->register(App\Providers\AppServiceProvider::class);
 $app->register(\App\Providers\ConfigServiceProvider::class);
 $app->register(\App\Providers\AliasesLoaderServiceProvider::class);
 $app->register(\App\Providers\GatewayServiceProvider::class);
 $app->register(\Illuminate\Redis\RedisServiceProvider::class);
 $app->register(\App\Providers\RepositoryServiceProvider::class);
 $app->register(\Illuminate\Foundation\Providers\FoundationServiceProvider::class);
 $app->register(\App\Providers\WechatServiceProvider::class);
 $app->register(\App\Providers\AliPayServiceProvider::class);
 $app->register(App\Providers\AuthServiceProvider::class);
 $app->register(App\Providers\EventServiceProvider::class);
 $app->register(\App\Providers\PaymentServiceProvider::class);
 $app->register(\App\Providers\OrderServiceProvider::class);
 $app->register(\App\Providers\RoutesManagerServiceProvider::class);


$app->configure('filesystems');
$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/
//$app->router->group([
//    'namespace' => 'App\Http\Controllers',
//], function ($router) {
//    require __DIR__.'/../routes/web.php';
//    require __DIR__.'/../routes/mp.php';
//});

return $app;
