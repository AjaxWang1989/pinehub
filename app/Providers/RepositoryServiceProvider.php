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
        $this->app->bind(\App\Repositories\ScoreRuleRepository::class, \App\Repositories\ScoreRuleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ScoreSettleCashRepository::class, \App\Repositories\ScoreSettleCashRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CustomerRepository::class, \App\Repositories\CustomerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MemberCardRepository::class, \App\Repositories\MemberCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CustomerTicketCardRepository::class, \App\Repositories\CustomerTicketCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CardRepository::class, \App\Repositories\CardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MemberRepository::class, \App\Repositories\MemberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OfficialAccountRepository::class, \App\Repositories\OfficialAccountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MiniProgramRepository::class, \App\Repositories\MiniProgramRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TicketRepository::class, \App\Repositories\TicketRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SellerRepository::class, \App\Repositories\SellerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopManagerRepository::class, \App\Repositories\ShopManagerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MerchandiseCategoryRepository::class, \App\Repositories\MerchandiseCategoryRepositoryEloquent::class);
        //:end-bindings:
        Log::debug("repository bindings\n");
    }
}
