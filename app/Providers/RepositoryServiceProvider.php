<?php

namespace App\Providers;

use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryEloquent;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryEloquent;
use App\Repositories\CountyRepository;
use App\Repositories\CountyRepositoryEloquent;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\ProvinceRepository;
use App\Repositories\ProvinceRepositoryEloquent;
use App\Repositories\ShopRepository;
use App\Repositories\ShopRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
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
        //
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(ShopRepository::class, ShopRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->bind(CountryRepository::class, CountryRepositoryEloquent::class);
        $this->app->bind(ProvinceRepository::class, ProvinceRepositoryEloquent::class);
        $this->app->bind(CityRepository::class, CityRepositoryEloquent::class);
        $this->app->bind(CountyRepository::class, CountyRepositoryEloquent::class);
    }
}
