<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 0:20
 */

namespace App\Observers;


use App\Entities\MpUser;
use App\Services\AppManager;
class MpUserObserver
{
    public function creating(MpUser $mpUser) {
        //$mpUser->type = MpUser::TYPE;
        $mpUser->appId = app(AppManager::class)->getAppId();
        return $mpUser;
    }
}