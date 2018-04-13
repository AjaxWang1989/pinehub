<?php

namespace App\Providers;

use App\Providers\LumenIdeHelperServiceProvider as IdeHelperServiceProvider;
use Dingo\Api\Provider\DingoServiceProvider;
use Dingo\Api\Provider\LumenServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\ServiceProvider;
use Irazasyed\JwtAuthGuard\JwtAuthGuardServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
//        $this->app->register(JwtAuthGuardServiceProvider::class);
        $this->app->register(LumenServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);

        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
