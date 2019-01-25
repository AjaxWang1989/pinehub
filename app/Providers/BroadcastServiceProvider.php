<?php

namespace App\Providers;

use App\Entities\Shop;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Broadcast::routes();
        $this->app->make('api.router')->any('/broadcasting/auth', [
            'as' => 'broadcasting.auth', 'version' => 'v1', 'uses' => BroadcastController::class.'@authenticate']);
        Broadcast::channel('shop-{shopId}', function ($user, $shopId) {
            $shop = Shop::find($shopId);
            return $user->id === $shop->userId;
        });
    }
}
