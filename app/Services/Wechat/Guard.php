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
    const EVENT_GET_CARD = 'user_get_card';
    const EVENT_CARD_CHECK_PASSED = 'card_pass_check';
    const EVENT_CARD_CHECK_NOT_PASSED = 'card_not_pass_check';
    const EVENT_USER_SEND_CARD = 'user_gifting_card';
    const EVENT_USER_DEL_CARD = 'user_del_card';
    const EVENT_USER_CONSUME_CARD = 'user_consume_card';
    const EVENT_USE_CARD_TO_PAY = 'User_pay_from_pay_cell';
    const EVENT_VIEW_MEMBER_CARD = 'user_view_card';
    const EVENT_ENTER_OFFICIAL_ACCOUNT_FROM_CARD = 'user_enter_session_from_card';
    const EVENT_MEMBER_SCORE_UPDATE = 'update_member_card';
    const EVENT_CARD_SKU_REMIND = 'card_sku_remind';
    const EVENT_CARD_PAY_ORDER = 'card_pay_order';
    const EVENT_MEMBER_CARD_ACTIVE = 'submit_membercard_user_info';
}