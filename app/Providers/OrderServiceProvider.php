<?php

namespace App\Providers;

use App\Repositories\MerchandiseRepositoryEloquent;
use App\Repositories\OrderItemMerchandiseRepositoryEloquent;
use App\Repositories\OrderItemRepositoryEloquent;
use App\Repositories\OrderPostRepositoryEloquent;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\SKUProductRepositoryEloquent;
use App\Services\OrderBuilder;
use Dingo\Api\Http\Request;
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
            $request = Request::capture();
            $input = collect($request->all());
            $auth = app('api.auth');
            return new OrderBuilder(
                $input,
                $auth,
                $app->make(OrderRepositoryEloquent::class),
                $app->make(MerchandiseRepositoryEloquent::class),
                $app->make(OrderItemRepositoryEloquent::class),
                $app->make(SKUProductRepositoryEloquent::class),
                $app->make(OrderItemMerchandiseRepositoryEloquent::class),
                $app->make(OrderPostRepositoryEloquent::class)
            );
        });
    }
}
