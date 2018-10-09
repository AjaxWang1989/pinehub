<?php

namespace App\Providers;

use App\Ali\Oauth\AliOauthServiceProvider;
use App\Http\Middleware\Cross;
use App\Providers\LumenIdeHelperServiceProvider as IdeHelperServiceProvider;
use App\Services\AppManager;
use App\Services\FileService;
use App\Services\UIDGeneratorService;
use Dingo\Api\Http\Request;
use Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Filesystem\FilesystemServiceProvider;
//use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Facades\{
    DB, Log, Validator
};
use Illuminate\Support\ServiceProvider;
use Jacobcyl\AliOSS\AliOssServiceProvider;
use Laravel\Lumen\Application;
use Laravoole\LaravooleServiceProvider;
use Mpociot\ApiDoc\ApiDocGeneratorServiceProvider;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;
use Zoran\JwtAuthGuard\JwtAuthGuardServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Overtrue\LaravelWeChat\ServiceProvider as WechatLumenServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if($this->app->environment() !== "production" && !$this->app->runningInConsole()){
            DB::listen(function (QueryExecuted $event){
                Log::debug($event->time.':'.$event->sql, $event->bindings);
            });
        }

        $this->app->singleton('file',function (Application $app) {
            return $app->make(FileService::class);
        });

        $this->app->bind(Factory::class, function () {
            return $this->app['filesystem'];
        });
        Validator::extend('not_exists', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($parameters[1], '=', $value)
                    ->count()<1;
        });

        Validator::extend('file_exist', function ($attribute, $value, $parameters) {
            return file_exists($value);
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Request::class, function (){
            return Request::capture();
        });
        laravelToLumen($this->app)->middleware(Cross::class);
        //$this->app->register(RedisServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(JwtAuthGuardServiceProvider::class);
        $this->app->register(WechatLumenServiceProvider::class);
        $this->app->register(AliOauthServiceProvider::class);
        $this->app->register(FilesystemServiceProvider::class);
        $this->app->register(AliOssServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(QrCodeServiceProvider::class);
        $this->app->singleton('uid.generator', function () {
            return new UIDGeneratorService();
        });
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(ApiDocGeneratorServiceProvider::class);
        }
        $this->app->singleton(AppManager::class, function (Application $app) {
            return new AppManager($app);
        });
       // $this->app->register(LaravooleServiceProvider::class);
        $this->app->register(LaravelSServiceProvider::class);
    }
}
