<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //:begin-bindings:
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopRepository::class, \App\Repositories\ShopRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CountryRepository::class, \App\Repositories\CountryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProvinceRepository::class, \App\Repositories\ProvinceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CityRepository::class, \App\Repositories\CityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CountyRepository::class, \App\Repositories\CountyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FileRepository::class, \App\Repositories\FileRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WechatConfigRepository::class, \App\Repositories\WechatConfigRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WechatMenuRepository::class, \App\Repositories\WechatMenuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WechatAutoReplyMessageRepository::class, \App\Repositories\WechatAutoReplyMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TakeOutCarRepository::class, \App\Repositories\TakeOutCarRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AppRepository::class, \App\Repositories\AppRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AppUserRepository::class, \App\Repositories\AppUserRepositoryEloquent::class);
        //:end-bindings:
        Log::debug("repository bindings\n");
    }
}
