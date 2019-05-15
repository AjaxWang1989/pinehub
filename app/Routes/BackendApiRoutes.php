<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 下午12:40
 */

namespace App\Routes;

use App\Excel\SendOrderSheet;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Router;
use Dingo\Api\Routing\Router as DingoRouter;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Routing\Router as LumenRouter;

class BackendApiRoutes extends ApiRoutes
{

    protected function routes($router)
    {
        parent::routes($router); // TODO: Change the autogenerated stub
        tap($router, function (Router $router) {
            $router->get('/open-platform/auth/sure', ['as' => 'open-platform.auth.sure', 'uses' => 'Wechat\OpenPlatformController@openPlatformAuthMakeSure']);
        });
    }

    /**
     * @param DingoRouter|LumenRouter $router
     * */
    protected function subRoutes($router)
    {
        tap($router, function (Router $router) {
            parent::subRoutes($router); // TODO: Change the autogenerated stub
            $attributes = [];

            if ($this->app->environment() !== 'local') {
                $attributes['middleware'] = ['api.auth'];
            }

            $router->get('/public/key', ['as' => 'administrator.public.key', 'uses' => 'AuthController@getPublicKey']);
            $router->post('/register', ['as' => 'administrator.register', 'uses' => 'AuthController@register']);
            $router->post('/login', ['as' => 'administrator.login', 'uses' => 'AuthController@authenticate']);
            $router->get('/refresh/token', ['as' => 'administrator.refresh.token', 'uses' => 'AuthController@RefreshToken']);
            $router->get('/store/{storeId}/payment/code', ['as' => 'store.payment.code', 'uses' => 'ShopsController@payQRCode']);
            $router->get('/ticket/{ticketId}/promote/qrcode', ['uses' => 'TicketController@promoteQRCode']);
            $router->get('/ticket/{ticketId}/promote/minicode', ['uses' => 'TicketController@promoteMiniCode']);
            $router->group($attributes, function ($router) {
                /**
                 * @var  LumenRouter|DingoRouter $router
                 * */

                $router->get('/logout', ['as' => 'administrator.logout', 'uses' => 'AuthController@logout']);
                $router->get('/users', ['as' => 'users.list', 'uses' => 'UsersController@getUsers']);
                $router->get('/user/{id}', ['as' => 'user.detail', 'uses' => 'UsersController@getUserDetail']);

                //登录用户信息路由
//                $router->get('/self/info', ['as' => 'self.info', 'uses' => 'MySelfController@selfInfo']);
//                $router->put('/change/password', ['as' => 'change.password', 'uses' => 'MySelfController@changePassword']);

                $router->post('/shop', ['as' => 'shop.create', 'uses' => 'ShopsController@store']);
                $router->get('/shops', ['as' => 'shop.list', 'uses' => 'ShopsController@index']);
                $router->get('/shop/{id}', ['as' => 'shop.detail', 'uses' => 'ShopsController@show']);
                $router->put('/shop/{id}', ['as' => 'shop.update', 'uses' => 'ShopsController@update']);
                $router->get('/shop/{shopId}/merchandises', ['as' => 'shop.merchandises', 'uses' => 'ShopsController@merchandises']);
                $router->post('/shop/{shopId}/merchandise', ['as' => 'shop.merchandise.create', 'uses' => 'ShopsController@addMerchandise']);
                $router->put('/shop/{shopId}/merchandise/{id}', ['as' => 'shop.merchandise.update', 'uses' => 'ShopsController@updateMerchandise']);

                $router->get('/orders', ['as' => 'orders', 'uses' => 'OrdersController@index']);
                $router->put('/order/{id}/sent', ['as' => 'order.sent', 'uses' => 'OrdersController@orderSent']);
                $router->get('/order/{id}', ['as' => 'order.show', 'uses' => 'OrdersController@show']);
                $router->get('/download/orders/xls', ['as' => 'orders.xls', 'uses' => 'OrdersController@downloadExcel']);

                $router->post('/app/logo/{driver?}', ['as' => 'app.logo.upload', 'uses' => 'AppController@uploadLogo']);
                $router->get('/apps', ['as' => 'app.list', 'uses' => 'AppController@index']);
                $router->post('/app', ['as' => 'app.create', 'uses' => 'AppController@store']);
                $router->put('/app/{id}', ['as' => 'app.update', 'uses' => 'AppController@update']);
                $router->get('/app/{id}', ['as' => 'app.show', 'uses' => 'AppController@show']);
                $router->delete('/app/{id}', ['as' => 'app.delete', 'uses' => 'AppController@destroy']);
                $router->post('/app/mp/config', ['as' => 'app.mp.config.create', 'uses' => 'AppController@setMpConfig']);
                $router->put('/app/mp/config/{id}', ['as' => 'app.mp.config.update', 'uses' => 'AppController@setMpConfig']);
                $router->get('/app/statistics/seven_days', ['as' => 'app.statistics.seven_days', 'uses' => 'AppController@sevenDaysStatistics']);

                $router->get('/customers', ['as' => 'customers', 'uses' => 'CustomersController@index']);

                $router->get('/members', ['as' => 'members', 'uses' => 'MembersController@index']);

                $router->get('/member/cards', ['as' => 'member.cards', 'uses' => 'MemberCardsController@index']);
                $router->post('/member/card', ['as' => 'member.card.create', 'uses' => 'MemberCardsController@store']);
                $router->get('/member/card/{id}', ['as' => 'member.card.show', 'uses' => 'MemberCardsController@show']);
                $router->put('/member/card/{id}', ['as' => 'member.card.update', 'uses' => 'MemberCardsController@update']);
                $router->delete('/member/card/{id}', ['as' => 'member.card.delete', 'uses' => 'MemberCardsController@destroy']);

                $router->post('/groupon/ticket', ['as' => 'groupon-ticket.create', 'middleware' => ['ticket:groupon'], 'uses' => 'TicketController@store']);
                $router->post('/discount/ticket', ['as' => 'discount-ticket.create', 'middleware' => ['ticket:discount'], 'uses' => 'TicketController@store']);
                $router->post('/coupon/ticket', ['as' => 'coupon-ticket.create', 'middleware' => ['ticket:coupon_card'], 'uses' => 'TicketController@store']);
                $router->post('/gift/ticket', ['as' => 'gift-ticket.create', 'middleware' => ['ticket:gift'], 'uses' => 'TicketController@store']);
                $router->post('/cash/ticket', ['as' => 'cash-ticket.create', 'middleware' => ['ticket:cash'], 'uses' => 'TicketController@store']);
                $router->post('/tickets', ['as' => 'ticket.create', 'uses' => 'TicketController@store']);

                $router->get('/tickets', ['as' => 'tickets', 'middleware' => ['ticket'], 'uses' => 'TicketController@index']);
                $router->get('/ticket/{id}', ['as' => 'ticket.show', 'uses' => 'TicketController@show']);
                $router->put('/ticket/{id}', ['as' => 'ticket.update', 'uses' => 'TicketController@update']);
                $router->get('/ticket/{ticketId}/template/{wxType}/{scene:[A-Za-z_]+}', ['uses' => 'TicketController@templateMessage']);
                $router->get('/ticket/{ticketId}/templates', ['uses' => 'TicketController@templateMessages']);
                $router->get('/ticket/{ticketId}/template/bind/{templateId:[0-9]+}', ['uses' => 'TicketController@bindTemplateMessage']);
                $router->get('/ticket/{ticketId}/template/unbind/{templateId:[0-9]+}', ['uses' => 'TicketController@unBindTemplateMessage']);
                $router->get('/ticket/templates/default', ['uses' => 'TicketController@defaultTemplateMessages']);
                $router->get('/ticket/template/default/bind/{templateId:[0-9]+}', ['uses' => 'TicketController@bindDefaultTemplateMessage']);
                $router->get('/ticket/template/default/unbind/{templateId:[0-9]+}', ['uses' => 'TicketController@unBindDefaultTemplateMessage']);

                $router->get('/score-rules', ['as' => 'score-rules', 'uses' => 'ScoreRulesController@index']);
                $router->get('/general/score/rule', ['as' => 'general-rule.show', 'uses' => 'ScoreRulesController@generalRule']);
                $router->get('/special/score/rules', ['as' => 'special-score-rules', 'uses' => 'ScoreRulesController@specialRules']);
                $router->get('/{type}/score-rules', ['as' => 'score-rules', 'uses' => 'ScoreRulesController@index']);
                $router->get('/score-rule/{id}', ['as' => 'score-rules', 'uses' => 'ScoreRulesController@show']);
                $router->post('/score-rule', ['as' => 'score-rule.create', 'uses' => 'ScoreRulesController@store']);
                $router->put('/score-rule/{id}', ['as' => 'score-rule.update', 'uses' => 'ScoreRulesController@update']);

                $router->get('new/merchandise/activity', ['as' => 'new-merchandise-activity', 'uses' => 'NewMerchandiseActivityController@activity']);
                $router->post('new/merchandise/activity', ['as' => 'new-merchandise-activity-create', 'uses' => 'NewMerchandiseActivityController@storeActivity']);
                $router->put('new/merchandise/activity/{id}', ['as' => 'new-merchandise-activity-update', 'uses' => 'NewMerchandiseActivityController@updateActivity']);
                $router->post('new/merchandise/activity/{activityId}/merchandise', ['as' => 'new-merchandise-activity-add-merchandise', 'uses' => 'NewMerchandiseActivityController@addMerchandise']);
                $router->post('new/merchandise/activity/upload/image/{driver?}', ['as' => 'new-merchandise-activity-upload-image', 'uses' => 'NewMerchandiseActivityController@uploadImage']);
                $router->put('new/merchandise/activity/{activityId}/merchandise/{merchandiseId}/stock', ['as' => 'new-merchandise-activity-merchandise-stock-update', 'uses' => 'NewMerchandiseActivityController@updateStock']);
                $router->get('new/merchandise/activity/{activityId}/merchandises', ['as' => 'new-merchandise-activity-merchandises', 'uses' => 'NewMerchandiseActivityController@merchandises']);
                $router->delete('new/merchandise/{id}/activity', ['as' => 'delete-merchandise-activity-merchandises', 'uses' => 'NewMerchandiseActivityController@removeMerchandise']);


                $router->get('categories', ['as' => 'categories.list', 'uses' => 'CategoriesController@index']);
                $router->post('category', ['as' => 'category.create', 'uses' => 'CategoriesController@store']);

                $router->get('merchandises', ['as' => 'merchandises.list', 'uses' => 'MerchandisesController@index']);
                $router->post('merchandise', ['as' => 'merchandise.create', 'uses' => 'MerchandisesController@store']);
                $router->put('merchandise/{id}', ['as' => 'merchandise.update', 'uses' => 'MerchandisesController@update']);
                $router->get('merchandise/{id}', ['as' => 'merchandise.show', 'uses' => 'MerchandisesController@show']);
                $router->post('merchandise/image/{driver?}', ['as' => 'merchandise.image.upload', 'uses' => 'MerchandisesController@uploadMerchandiseImage']);

                $router->post('payment_activity/{type}', ['as' => 'payment_activity.create', 'uses' => 'PaymentActivityController@store']);
                $router->put('payment_activity/{id}', ['as' => 'payment_activity.update', 'uses' => 'PaymentActivityController@update']);
                $router->get('payment_activities/{type?}', ['as' => 'payment_activity.list', 'uses' => 'PaymentActivityController@index']);
                $router->get('payment_activity/{id}', ['as' => 'payment_activity.show', 'uses' => 'PaymentActivityController@show']);

                $router->get('advertisements', ['as' => 'advertisement.list', 'uses' => 'AdvertisementController@index']);
                $router->post('advertisement', ['as' => 'advertisement.create', 'uses' => 'AdvertisementController@store']);
                $router->put('advertisement/{id}', ['as' => 'advertisement.update', 'uses' => 'AdvertisementController@update']);

                $router->group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function ($router) {
                    /**
                     * @var LumenRouter|DingoRouter $router
                     * */
                    $router->post("config", ['as' => 'wechat.config.create', 'uses' => 'ConfigController@store']);
                    $router->get("configs", ['as' => 'wechat.config.list', 'uses' => 'ConfigController@index']);
                    $router->get("config/{id}", ['as' => 'wechat.config.show', 'uses' => 'ConfigController@show']);
                    $router->put("config/{id}", ['as' => 'wechat.config.update', 'uses' => 'ConfigController@update']);
                    $router->delete("configs", ['as' => 'wechat.config.delete.bat', 'uses' => 'ConfigController@destroy']);
                    $router->delete("config/{id}", ['as' => 'wechat.config.delete', 'uses' => 'ConfigController@destroy']);

                    //menus
                    $router->post("menu", ['as' => 'wechat.menu.create', 'uses' => 'MenuController@store']);
                    $router->get("menus", ['as' => 'wechat.menu.list', 'uses' => 'MenuController@index']);
                    $router->get("{appId}/menus", ['as' => 'wechat.app.menus', 'uses' => 'MenuController@index']);
                    $router->get("menu/{id}", ['as' => 'wechat.menu.show', 'uses' => 'MenuController@show']);
                    $router->put("menu/{id}", ['as' => 'wechat.menu.update', 'uses' => 'MenuController@update']);
                    $router->delete("menu/{id}", ['as' => 'wechat.menu.delete', 'uses' => 'MenuController@destroy']);
                    $router->delete("menus", ['as' => 'wechat.menu.delete.bat', 'uses' => 'MenuController@destroy']);
                    $router->get("menu/{id}/sync", ['as' => 'wechat.menu.sync', 'uses' => 'MenuController@sync']);

                    //material api

                    $router->post("media/temporary", ['as' => 'wechat.temporary.media.create', 'uses' => 'MaterialController@storeTemporaryMedia']);
                    $router->post("material/article", ['as' => 'wechat.article.create', 'uses' => 'MaterialController@storeForeverNews']);
                    $router->post("{type}/material", ['as' => 'wechat.material.create', 'uses' => 'MaterialController@uploadForeverMaterial']);
                    $router->get("material/stats", ['as' => 'wechat.material.stats', 'uses' => 'MaterialController@materialStats']);
                    $router->get("materials", ['as' => 'wechat.materials', 'uses' => 'MaterialController@materialList']);
                    $router->get("material", ['as' => 'wechat.material.view', 'uses' => 'MaterialController@materialView']);
                    $router->get("material/{mediaId}", ['as' => 'wechat.material.forever.detail', 'uses' => 'MaterialController@material']);
                    $router->get("material/{mediaId}/{type}", ['as' => 'wechat.material.temporary.detail', 'uses' => 'MaterialController@material']);
                    $router->put("material/article/{mediaId}", ['as' => 'wechat.article.update', 'uses' => 'MaterialController@materialNewsUpdate']);
                    $router->delete("material/{mediaId}", ['as' => 'wechat.material.delete', 'uses' => 'MenuController@deleteMaterial']);

                    //auto reply message
                    $router->post("auto_reply_message", ['as' => 'wechat.auto_reply_message.create', 'uses' => 'AutoReplyMessagesController@store']);
                    $router->get("auto_reply_messages", ['as' => 'wechat.auto_reply_message.list', 'uses' => 'AutoReplyMessagesController@index']);
                    $router->get("auto_reply_message/{id}", ['as' => 'wechat.auto_reply_message.show', 'uses' => 'AutoReplyMessagesController@show']);
                    $router->put("auto_reply_message/{id}", ['as' => 'wechat.auto_reply_message.update', 'uses' => 'AutoReplyMessagesController@update']);
                    $router->delete("auto_reply_message/{id}", ['as' => 'wechat.auto_reply_message.delete', 'uses' => 'AutoReplyMessagesController@destroy']);
                    $router->delete("auto_reply_messages", ['as' => 'wechat.auto_reply_message.delete.bat', 'uses' => 'AutoReplyMessagesController@destroy']);

                    // template message --- Official Account
                    $router->group(['prefix' => 'template'], function (Router $router) {
                        $router->get('sync', ['uses' => 'WxTemplateMessageController@syncOfficialAccount']);
                        $router->get('sync/check', ['uses' => 'WxTemplateMessageController@syncOfficialAccountCheck']);
                        $router->get('list', ['uses' => 'WxTemplateMessageController@privateTemplates']);
                    });

                    // template message --- Miniprogram
                    $router->group(['prefix' => 'wxopen/template'], function (Router $router) {
                        $router->get('sync', ['uses' => 'WxTemplateMessageController@syncMiniProgram']);
                        $router->get('sync/check', ['uses' => 'WxTemplateMessageController@syncMiniProgramCheck']);
                        $router->get('list', ['uses' => 'WxTemplateMessageController@templates']);

                        $router->group(['prefix' => 'custom'], function (Router $router) {
                            $router->get('/{parentId:[0-9]+}', ['uses' => 'UserTemplateMessageController@templates']);
                            $router->get('/{wxType:[A-Za-z_]+}', ['uses' => 'UserTemplateMessageController@index']);
                            $router->post('/', ['uses' => 'UserTemplateMessageController@create']);
                            $router->put('/{id}', ['uses' => 'UserTemplateMessageController@update']);
                            $router->delete('/{id}', ['uses' => 'UserTemplateMessageController@delete']);
                        });
                        // Just for test : fetch templates data
                        $router->get('list/test', ['uses' => 'WxTemplateMessageController@templatesTest']);
                    });
                });

                $router->group(['prefix' => 'rechargeable_cards'], function (Router $router) {
                    $router->get('/', ['as' => 'rechargeable_card.list', 'uses' => 'RechargeableCardController@index']);
                    $router->get('/{id:[0-9]+}', ['as' => 'rechargeable_card.detail', 'uses' => 'RechargeableCardController@show']);
                    $router->post('/', ['as' => 'rechargeable_card.create', 'uses' => 'RechargeableCardController@store']);
                    $router->put('/{id}', ['as' => 'rechargeable_card.update', 'uses' => 'RechargeableCardController@update']);
                    $router->delete('/{id}', ['as' => 'rechargeable_card.delete', 'uses' => 'RechargeableCardController@delete']);
                });
            });


            $router->get('/countries', ['as' => 'country.list', 'uses' => 'CountriesController@index']);
            $router->get('/country/{id}', ['as' => 'country.detail', 'uses' => 'CountriesController@show']);
            $router->post('/country', ['as' => 'country.create', 'uses' => 'CountriesController@store']);
            $router->put('/country/{id}', ['as' => 'country.update', 'uses' => 'CountriesController@update']);
            $router->delete('/country/{id}', ['as' => 'country.delete', 'uses' => 'CountriesController@destroy']);

            $router->get('/country/{countryId}/provinces', ['as' => 'province.list.country', 'uses' => 'ProvincesController@index']);
            $router->get('/provinces', ['as' => 'province.list', 'uses' => 'ProvincesController@index']);
            $router->get('/province/{id}', ['as' => 'province.detail', 'uses' => 'ProvincesController@show']);
            $router->post('/country/{countryId}/province', ['as' => 'province.create.country', 'uses' => 'ProvincesController@store']);
            $router->post('/province', ['as' => 'province.create', 'uses' => 'ProvincesController@store']);
            $router->put('/province/{id}', ['as' => 'province.update', 'uses' => 'ProvincesController@update']);

            //$router->get('/country/{countryId}/cities', ['as' => 'city.list.country', 'uses' => 'CitiesController@index']);
            $router->get('/country/{id}/cities', ['as' => 'city.list.country', 'uses' => 'CitiesController@index']);
            $router->get('/province/{id}/cities', ['as' => 'city.list.province', 'uses' => 'CitiesController@index']);
            $router->get('/cities', ['as' => 'city.list.all', 'uses' => 'CitiesController@index']);
            $router->get('/city/{id}', ['as' => 'city.detail', 'uses' => 'CitiesController@show']);
            $router->post('/city', ['as' => 'city.create', 'uses' => 'CitiesController@store']);
            $router->post('/province/{provinceId}/cities', ['as' => 'city.create.province', 'uses' => 'CitiesController@store']);
            $router->put('/city/{id}', ['as' => 'city.update', 'uses' => 'CitiesController@update']);

            $router->get('/country/{id}/counties', ['as' => 'county.list.country', 'uses' => 'CountiesController@index']);
            $router->get('/province/{id}/counties', ['as' => 'county.list.province', 'uses' => 'CountiesController@index']);
            $router->get('/city/{id}/counties', ['as' => 'county.list.city', 'uses' => 'CountiesController@index']);
            $router->get('/counties', ['as' => 'county.list', 'uses' => 'CountiesController@index']);
            $router->get('/county/{id}', ['as' => 'county.show', 'uses' => 'CountiesController@show']);
            $router->post('/city/{cityId}/county', ['as' => 'county.create.city', 'uses' => 'CountiesController@store']);
            $router->post('/county', ['as' => 'county.create', 'uses' => 'CountiesController@store']);
            $router->put('/county/{id}', ['as' => 'county.update', 'uses' => 'CountiesController@update']);

            $router->get('excel/test', function (Request $request) {
                try {
                    app()->make(SendOrderSheet::class)->download();
//                    $cellData = [
//                        ['学号','姓名','成绩'],
//                        ['10001','AAAAA','99'],
//                        ['10002','BBBBB','92'],
//                        ['10003','CCCCC','95'],
//                        ['10004','DDDDD','89'],
//                        ['10005','EEEEE','96'],
//                    ];
//                    Excel::create('学生成绩',function(LaravelExcelWriter $excel) use ($cellData){
//                        $excel->sheet('score', function(LaravelExcelWorksheet $sheet) use ($cellData){
//                            $sheet->rows($cellData);
//                        });
//                    })->export('xls');
                } catch (\Exception $exception) {
                    Log::info('exception ' . $exception->getMessage());
                    return 'exception ' . $exception->getMessage() . ' ' . $exception->getTraceAsString();
                }

                return 'test';
            });

        });
    }
}
