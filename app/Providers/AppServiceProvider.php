<?php

namespace App\Providers;

use App\Ali\Oauth\AliOauthServiceProvider;
use App\Http\Middleware\Cross;
use App\Providers\LumenIdeHelperServiceProvider as IdeHelperServiceProvider;
use App\Services\FileService;
use App\Services\UIDGeneratorService;
use Grimzy\LaravelMysqlSpatial\SpatialServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\Facades\{
    DB, Log
};
use Illuminate\Support\ServiceProvider;
use Jacobcyl\AliOSS\AliOssServiceProvider;
use Laravel\Lumen\Application;
use Mpociot\ApiDoc\ApiDocGeneratorServiceProvider;
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
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        laravelToLumen($this->app)->middleware(Cross::class);
        $this->app->register(RedisServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(JwtAuthGuardServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(WechatLumenServiceProvider::class);
        $this->app->register(SpatialServiceProvider::class);
        $this->app->register(AliOauthServiceProvider::class);
        $this->app->register(FilesystemServiceProvider::class);
        $this->app->register(AliOssServiceProvider::class);
        $this->app->singleton('uid.generator', function () {
            return new UIDGeneratorService();
        });
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(ApiDocGeneratorServiceProvider::class);
        }
    }
}
