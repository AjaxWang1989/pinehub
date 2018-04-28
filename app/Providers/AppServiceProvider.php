<?php

namespace App\Providers;

use App\Providers\LumenIdeHelperServiceProvider as IdeHelperServiceProvider;
use Dingo\Api\Provider\LumenServiceProvider;
use Grimzy\LaravelMysqlSpatial\SpatialServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Zoran\JwtAuthGuard\JwtAuthGuardServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Overtrue\LaravelWeChat\ServiceProvider as WechatLumenServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        DB::listen(function (QueryExecuted $event){
            Log::debug($event->time.':'.$event->sql, $event->bindings);
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
        $this->app->register(RedisServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(JwtAuthGuardServiceProvider::class);
        $this->app->register(LumenServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(WechatLumenServiceProvider::class);
        $this->app->register(SpatialServiceProvider::class);

        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
