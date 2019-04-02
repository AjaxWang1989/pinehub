<?php

namespace App\Providers;

use App\Repositories\AdvertisementRepository;
use App\Repositories\AdvertisementRepositoryEloquent;
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
        $this->app->bind(\App\Repositories\MerchandiseRepository::class, \App\Repositories\MerchandiseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentActivityRepository::class, \App\Repositories\PaymentActivityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MiniProgramPageRepository::class, \App\Repositories\MiniProgramPageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MiniProgramTemplateRepository::class, \App\Repositories\MiniProgramTemplateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MiniProgramDraftRepository::class, \App\Repositories\MiniProgramDraftRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WechatUserRepository::class, \App\Repositories\WechatUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopMerchandiseRepository::class, \App\Repositories\ShopMerchandiseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ActivityRepository::class, \App\Repositories\ActivityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ActivityMerchandiseRepository::class, \App\Repositories\ActivityMerchandiseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MpUserRepository::class, \App\Repositories\MpUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserTicketRepository::class, \App\Repositories\UserTicketRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShoppingCartRepository::class, \App\Repositories\ShoppingCartRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShopMerchandiseStockModifyRepository::class, \App\Repositories\ShopMerchandiseStockModifyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderItemRepository::class, \App\Repositories\OrderItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StorePurchaseOrdersRepository::class, \App\Repositories\StorePurchaseOrdersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderPurchaseItemsRepository::class, \App\Repositories\OrderPurchaseItemsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WechatMaterialRepository::class, \App\Repositories\WechatMaterialRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdministratorRepository::class, \App\Repositories\AdministratorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedBackMessageRepository::class, \App\Repositories\FeedBackMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SKUProductRepository::class, \App\Repositories\SKUProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderPostRepository::class, \App\Repositories\OrderPostRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MemberCardInfoRepository::class, \App\Repositories\MemberCardInfoRepositoryEloquent::class);
        $this->app->bind(AdvertisementRepository::class, AdvertisementRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WxTemplateMessageRepository::class, \App\Repositories\WxTemplateMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserTemplateMessageRepository::class, \App\Repositories\UserTemplateMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentConfigRepository::class, \App\Repositories\PaymentConfigRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TicketTemplateMessageRepository::class, \App\Repositories\TicketTemplateMessageRepositoryEloquent::class);
        //:end-bindings:
    }
}
