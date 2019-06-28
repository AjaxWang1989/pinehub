<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/6/28
 * Time: 10:48 PM
 */

use Illuminate\Support\Facades\Broadcast;
use App\Entities\ShopManager;
Broadcast::channel('paid-notice-{shopId}', function (ShopManager $manager, $shopId) {
    return $shopId == $manager->shop->id;
});