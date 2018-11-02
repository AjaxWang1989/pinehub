<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/6
 * Time: 上午10:34
 */

namespace App\Observers;


use App\Entities\WechatMenu;
use App\Exceptions\MenuSyncFail;
use App\Services\AppManager;
use Illuminate\Support\Facades\Log;

class WechatMenuObserver
{
    public function creating(WechatMenu $menu)
    {
        $menu->appId = app(AppManager::class)->currentApp->officialAccount->appId;
        return $menu;
    }

    protected function sync(WechatMenu $menu)
    {

    }

    public function updating(WechatMenu $menu)
    {
        $menu->isPublic = $menu->isPublic ? !$menu->isPublic : $menu->isPublic;
        if($menu->isPublic)
        {
            $buttons = $menu->menus;
            foreach ($buttons['button'] as &$button) {
                unset($button['width']);
                if(empty($button['sub_button'])) {
                    unset($button['sub_button']);
                }else{
                    unset($button['type']);
                }
            }
            Log::info('sync menus', $buttons);
            $result = app('wechat')->officeAccount()->menu->create($buttons['button']);
            Log::info('sync menus', $result);
            if($result['errcode'] !== 0) {
                throw new MenuSyncFail($result['message']);
            }
        }
        return $menu;
    }

    public function created(WechatMenu $menu)
    {

    }

    public function updated(WechatMenu $menu)
    {

    }
}