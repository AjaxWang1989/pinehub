<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/27
 * Time: 下午4:43
 */

namespace App\Services\Wechat;

use EasyWeChat\OpenPlatform\Server\Guard as GuardServer;
class Guard extends GuardServer
{
    const EVENT_SUBSCRIBE = 'subscribe';
    const EVENT_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_SCAN = 'SCAN';
    const EVENT_LOCATION = 'LOCATION';
    const EVENT_CLICK = 'CLICK';
    const EVENT_VIEW = 'VIEW';
}