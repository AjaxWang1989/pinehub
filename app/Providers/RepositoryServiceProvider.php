<?php

namespace App\Providers;

use App\Repositories\ActivityMerchandiseRepository;
use App\Repositories\ActivityMerchandiseRepositoryEloquent;
use App\Repositories\ActivityRepository;
use App\Repositories\ActivityRepositoryEloquent;
use App\Repositories\AdministratorRepository;
use App\Repositories\AdministratorRepositoryEloquent;
use App\Repositories\AdvertisementRepository;
use App\Repositories\AdvertisementRepositoryEloquent;
use App\Repositories\AppRepository;
use App\Repositories\AppRepositoryEloquent;
use App\Repositories\AppUserRepository;
use App\Repositories\AppUserRepositoryEloquent;
use App\Repositories\CardRepository;
use App\Repositories\CardRepositoryEloquent;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryEloquent;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryEloquent;
use App\Repositories\CountyRepository;
use App\Repositories\CountyRepositoryEloquent;
use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryEloquent;
use App\Repositories\CustomerTicketCardRepository;
use App\Repositories\CustomerTicketCardRepositoryEloquent;
use App\Repositories\FeedBackMessageRepository;
use App\Repositories\FeedBackMessageRepositoryEloquent;
use App\Repositories\FileRepository;
use App\Repositories\FileRepositoryEloquent;
use App\Repositories\MemberCardInfoRepository;
use App\Repositories\MemberCardInfoRepositoryEloquent;
use App\Repositories\MemberCardRepository;
use App\Repositories\MemberCardRepositoryEloquent;
use App\Repositories\MemberRepository;
use App\Repositories\MemberRepositoryEloquent;
use App\Repositories\MerchandiseCategoryRepository;
use App\Repositories\MerchandiseCategoryRepositoryEloquent;
use App\Repositories\MerchandiseRepository;
use App\Repositories\MerchandiseRepositoryEloquent;
use App\Repositories\MiniProgramDraftRepository;
use App\Repositories\MiniProgramDraftRepositoryEloquent;
use App\Repositories\MiniProgramPageRepository;
use App\Repositories\MiniProgramPageRepositoryEloquent;
use App\Repositories\MiniProgramRepository;
use App\Repositories\MiniProgramRepositoryEloquent;
use App\Repositories\MiniProgramTemplateRepository;
use App\Repositories\MiniProgramTemplateRepositoryEloquent;
use App\Repositories\MpUserRepository;
use App\Repositories\MpUserRepositoryEloquent;
use App\Repositories\OfficialAccountRepository;
use App\Repositories\OfficialAccountRepositoryEloquent;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderItemRepositoryEloquent;
use App\Repositories\OrderPostRepository;
use App\Repositories\OrderPostRepositoryEloquent;
use App\Repositories\OrderPurchaseItemsRepository;
use App\Repositories\OrderPurchaseItemsRepositoryEloquent;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\PaymentActivityRepository;
use App\Repositories\PaymentActivityRepositoryEloquent;
use App\Repositories\PaymentConfigRepository;
use App\Repositories\PaymentConfigRepositoryEloquent;
use App\Repositories\ProvinceRepository;
use App\Repositories\ProvinceRepositoryEloquent;
use App\Repositories\RechargeableCardRepository;
use App\Repositories\RechargeableCardRepositoryEloquent;
use App\Repositories\ScoreRuleRepository;
use App\Repositories\ScoreRuleRepositoryEloquent;
use App\Repositories\ScoreSettleCashRepository;
use App\Repositories\ScoreSettleCashRepositoryEloquent;
use App\Repositories\SellerRepository;
use App\Repositories\SellerRepositoryEloquent;
use App\Repositories\ShopManagerRepository;
use App\Repositories\ShopManagerRepositoryEloquent;
use App\Repositories\ShopMerchandiseRepository;
use App\Repositories\ShopMerchandiseRepositoryEloquent;
use App\Repositories\ShopMerchandiseStockModifyRepository;
use App\Repositories\ShopMerchandiseStockModifyRepositoryEloquent;
use App\Repositories\ShoppingCartRepository;
use App\Repositories\ShoppingCartRepositoryEloquent;
use App\Repositories\ShopRepository;
use App\Repositories\ShopRepositoryEloquent;
use App\Repositories\SKUProductRepository;
use App\Repositories\SKUProductRepositoryEloquent;
use App\Repositories\StorePurchaseOrdersRepository;
use App\Repositories\StorePurchaseOrdersRepositoryEloquent;
use App\Repositories\TakeOutCarRepository;
use App\Repositories\TakeOutCarRepositoryEloquent;
use App\Repositories\TicketRepository;
use App\Repositories\TicketRepositoryEloquent;
use App\Repositories\TicketTemplateMessageRepository;
use App\Repositories\TicketTemplateMessageRepositoryEloquent;
use App\Repositories\UserRechargeableCardConsumeRecordRepository;
use App\Repositories\UserRechargeableCardConsumeRecordRepositoryEloquent;
use App\Repositories\UserRechargeableCardRepository;
use App\Repositories\UserRechargeableCardRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\UserTemplateMessageRepository;
use App\Repositories\UserTemplateMessageRepositoryEloquent;
use App\Repositories\UserTicketRepository;
use App\Repositories\UserTicketRepositoryEloquent;
use App\Repositories\WechatAutoReplyMessageRepository;
use App\Repositories\WechatAutoReplyMessageRepositoryEloquent;
use App\Repositories\WechatConfigRepository;
use App\Repositories\WechatConfigRepositoryEloquent;
use App\Repositories\WechatMaterialRepository;
use App\Repositories\WechatMaterialRepositoryEloquent;
use App\Repositories\WechatMenuRepository;
use App\Repositories\WechatMenuRepositoryEloquent;
use App\Repositories\WechatUserRepository;
use App\Repositories\WechatUserRepositoryEloquent;
use App\Repositories\WxTemplateMessageRepository;
use App\Repositories\WxTemplateMessageRepositoryEloquent;
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
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(ShopRepository::class, ShopRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->bind(CountryRepository::class, CountryRepositoryEloquent::class);
        $this->app->bind(ProvinceRepository::class, ProvinceRepositoryEloquent::class);
        $this->app->bind(CityRepository::class, CityRepositoryEloquent::class);
        $this->app->bind(CountyRepository::class, CountyRepositoryEloquent::class);
        $this->app->bind(FileRepository::class, FileRepositoryEloquent::class);
        $this->app->bind(WechatConfigRepository::class, WechatConfigRepositoryEloquent::class);
        $this->app->bind(WechatMenuRepository::class, WechatMenuRepositoryEloquent::class);
        $this->app->bind(WechatAutoReplyMessageRepository::class, WechatAutoReplyMessageRepositoryEloquent::class);
        $this->app->bind(TakeOutCarRepository::class, TakeOutCarRepositoryEloquent::class);
        $this->app->bind(AppRepository::class, AppRepositoryEloquent::class);
        $this->app->bind(AppUserRepository::class, AppUserRepositoryEloquent::class);
        $this->app->bind(ScoreRuleRepository::class, ScoreRuleRepositoryEloquent::class);
        $this->app->bind(ScoreSettleCashRepository::class, ScoreSettleCashRepositoryEloquent::class);
        $this->app->bind(CustomerRepository::class, CustomerRepositoryEloquent::class);
        $this->app->bind(MemberCardRepository::class, MemberCardRepositoryEloquent::class);
        $this->app->bind(CustomerTicketCardRepository::class, CustomerTicketCardRepositoryEloquent::class);
        $this->app->bind(CardRepository::class, CardRepositoryEloquent::class);
        $this->app->bind(MemberRepository::class, MemberRepositoryEloquent::class);
        $this->app->bind(OfficialAccountRepository::class, OfficialAccountRepositoryEloquent::class);
        $this->app->bind(MiniProgramRepository::class, MiniProgramRepositoryEloquent::class);
        $this->app->bind(TicketRepository::class, TicketRepositoryEloquent::class);
        $this->app->bind(SellerRepository::class, SellerRepositoryEloquent::class);
        $this->app->bind(ShopManagerRepository::class, ShopManagerRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(MerchandiseCategoryRepository::class, MerchandiseCategoryRepositoryEloquent::class);
        $this->app->bind(MerchandiseRepository::class, MerchandiseRepositoryEloquent::class);
        $this->app->bind(PaymentActivityRepository::class, PaymentActivityRepositoryEloquent::class);
        $this->app->bind(MiniProgramPageRepository::class, MiniProgramPageRepositoryEloquent::class);
        $this->app->bind(MiniProgramTemplateRepository::class, MiniProgramTemplateRepositoryEloquent::class);
        $this->app->bind(MiniProgramDraftRepository::class, MiniProgramDraftRepositoryEloquent::class);
        $this->app->bind(WechatUserRepository::class, WechatUserRepositoryEloquent::class);
        $this->app->bind(ShopMerchandiseRepository::class, ShopMerchandiseRepositoryEloquent::class);
        $this->app->bind(ActivityRepository::class, ActivityRepositoryEloquent::class);
        $this->app->bind(ActivityMerchandiseRepository::class, ActivityMerchandiseRepositoryEloquent::class);
        $this->app->bind(MpUserRepository::class, MpUserRepositoryEloquent::class);
        $this->app->bind(UserTicketRepository::class, UserTicketRepositoryEloquent::class);
        $this->app->bind(ShoppingCartRepository::class, ShoppingCartRepositoryEloquent::class);
        $this->app->bind(ShopMerchandiseStockModifyRepository::class, ShopMerchandiseStockModifyRepositoryEloquent::class);
        $this->app->bind(OrderItemRepository::class, OrderItemRepositoryEloquent::class);
        $this->app->bind(StorePurchaseOrdersRepository::class, StorePurchaseOrdersRepositoryEloquent::class);
        $this->app->bind(OrderPurchaseItemsRepository::class, OrderPurchaseItemsRepositoryEloquent::class);
        $this->app->bind(WechatMaterialRepository::class, WechatMaterialRepositoryEloquent::class);
        $this->app->bind(AdministratorRepository::class, AdministratorRepositoryEloquent::class);
        $this->app->bind(FeedBackMessageRepository::class, FeedBackMessageRepositoryEloquent::class);
        $this->app->bind(SKUProductRepository::class, SKUProductRepositoryEloquent::class);
        $this->app->bind(OrderPostRepository::class, OrderPostRepositoryEloquent::class);
        $this->app->bind(MemberCardInfoRepository::class, MemberCardInfoRepositoryEloquent::class);
        $this->app->bind(AdvertisementRepository::class, AdvertisementRepositoryEloquent::class);
        $this->app->bind(WxTemplateMessageRepository::class, WxTemplateMessageRepositoryEloquent::class);
        $this->app->bind(UserTemplateMessageRepository::class, UserTemplateMessageRepositoryEloquent::class);
        $this->app->bind(PaymentConfigRepository::class, PaymentConfigRepositoryEloquent::class);
        $this->app->bind(TicketTemplateMessageRepository::class, TicketTemplateMessageRepositoryEloquent::class);
        $this->app->bind(WxTemplateMessageRepository::class, WxTemplateMessageRepositoryEloquent::class);
        $this->app->bind(RechargeableCardRepository::class, RechargeableCardRepositoryEloquent::class);
        $this->app->bind(UserRechargeableCardConsumeRecordRepository::class, UserRechargeableCardConsumeRecordRepositoryEloquent::class);
        $this->app->bind(UserRechargeableCardRepository::class, UserRechargeableCardRepositoryEloquent::class);
        //:end-bindings:
    }
}
