<?php

namespace App\Providers;

use App\Repositories\MerchandiseRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderPostRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SKUProductRepository;
use App\Services\OrderBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class OrderServiceProvider extends ServiceProvider
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
        $this->app->singleton('order.builder', function (Application $app){
            $request = $app->make('request');
            $input = collect($request->all());
            $auth = app('api.auth');
            return new OrderBuilder(
                $input,
                $auth,
                $app->make(OrderRepository::class),
                $app->make(MerchandiseRepository::class),
                $app->make(OrderItemRepository::class),
                $app->make(SKUProductRepository::class),
                $app->make(OrderPostRepository::class)
            );
        });
    }
}
