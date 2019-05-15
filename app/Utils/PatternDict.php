<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/14
 * Time: 上午10:25
 */

define('MOBILE_PATTERN', '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/');
//电信
define('CT_MOBILE_PATTERN', '/^(133|153|180|181|189|177)\d{8}$/');
//联通
define('CU_MOBILE_PATTERN', '/^(13[0-2]|155|156|145|185|186|176)\d{8}$/');
//移动
define('CM_MOBILE_PATTERN', '/^(134[0-9][0-8])\d{6}|(13[5-9]|15[0,1,2,7,8,9]|18[2,3,4,7,8]|147|178)\d{8}$/');

define('PASSWORD_PATTERN', '/^[a-zA-Z0-9\@\!\$\&\%]{6,20}/');

define('USER_NAME_MAX_LENGTH', 64);

define('UNKNOWN', 'UNKNOWN');

define('SEX_ALL', 'ALL');

define('MALE', 'MALE');

define('FEMALE', 'FEMALE');

define('IMAGE_URL_PATTERN', '/^(http|https):\/\/(.*)\.(gif|jpg|GIF|JPG|png)$/');

define('CHINA_MOBILE', '中国移动');

define('CHINA_UNION', '中国联通');

define('CHINA_TEL', '中国电信');

define('PAGE_LIMIT', 15);

define('ALI_PAY_USER_AGENT', '/alipayclient/i');

define('WECHAT_PAY_USER_AGENT', '/micromessenger/i');

define('HTTP_METHOD_GET', 'GET');
define('HTTP_METHOD_POST', 'POST');
define('HTTP_METHOD_PUT', 'PUT');
define('HTTP_METHOD_DELETE', 'DELETE');
define('HTTP_METHOD_HEADER', 'HEADER');
define('HTTP_METHOD_OPTIONS', 'OPTIONS');

define('SEGMENT_MAX_LENGTH', 1000);
define('ORDER_SEGMENT_MAX_LENGTH', 100);

define('ORDER_CODE_FORMAT', 'YmdHis');

define('MEMBER_CARD_SEGMENT_MAX_LENGTH', 100);

define('MEMBER_CARD_CODE_FORMAT', 'Ymd');

define('TICKET_SEGMENT_MAX_LENGTH', 100);

define('TICKET_CODE_FORMAT', 'YmdHis');

define('SHOP_CODE_FORMAT', 'Ymd');
define('SHOP_CODE_SEGMENT_MAX_LENGTH', 100);

define('MERCHANDISE_SEGMENT_MAX_LENGTH', 100);
define('MERCHANDISE_CODE_FORMAT', 'YmdH');

define('ONE_DAY_SECONDS', 86400);

define('USER_AUTH_BASE', 'user_base');
define('USER_AUTH_INFO', 'user_info');

define('MEMBER_CARD', 'member_card');

define('OWNER_TICKET', 'OWNER_TICKET');
define('WX_TICKET', 'WX_TICKET');
define('ALI_TICKET', 'ALI_TICKET');

define('COUPON_CARD', 'coupon');
define('GROUPON_CARD', 'groupon');
define('DISCOUNT_CARD', 'discount');
define('CASH_CARD', 'cash');
define('GIFT_CARD', 'gift');

define('WECHAT_THUMB_MESSAGE', 'thumb');

define('WECHAT_NEWS_IMAGE_MESSAGE', 'news_image');

define('WECHAT_TEXT_MESSAGE', 'text');

define('WECHAT_IMAGE_MESSAGE', 'image');

define('WECHAT_VOICE_MESSAGE', 'voice');

define('WECHAT_EVENT_MESSAGE', 'event');

define('WECHAT_NEWS_MESSAGE', 'news');

define('WECHAT_VIDEO_MESSAGE', 'video');

define('WECHAT_MUSIC_MESSAGE', 'music');

define('OPEN_PLATFORM_COMPONENT_VERIFY_TICKET', 'component_verify_ticket');

define('VIEW_BUTTON', 'view');

define('CLICK_BUTTON', 'click');

define('MP_BUTTON', 'miniprogram');

define('SCAN_CODE_PUSH_BUTTON', 'scancode_push');

define('SCAN_CODE_WAIT_MSG_BUTTON', 'scancode_waitmsg');

define('PIC_SYS_PHOTO_BUTTON', 'pic_sysphoto');

define('PIC_PHOTO_OR_ALBUM_BUTTON', 'pic_photo_or_album');

define('PIC_WEI_XIN_BUTTON', 'pic_weixin');

define('LOCATION_SELECT_BUTTON', 'location_select');

define('MEDIA_ID_BUTTON', 'media_id');

define('VIEW_LIMITED_BUTTON', 'view_limited');

define('WECHAT_MENU_TYPE', [
    VIEW_BUTTON,
    CLICK_BUTTON,
    MP_BUTTON,
    SCAN_CODE_PUSH_BUTTON,
    SCAN_CODE_WAIT_MSG_BUTTON,
    PIC_SYS_PHOTO_BUTTON,
    PIC_PHOTO_OR_ALBUM_BUTTON,
    PIC_WEI_XIN_BUTTON,
    LOCATION_SELECT_BUTTON,
    MEDIA_ID_BUTTON,
    VIEW_LIMITED_BUTTON
]);

define('WECHAT_APP_ID', '/^(wx)[0-9a-fA-F]{16}/');

define('WECHAT_APP_SECRET', '/[0-9a-fA-F]{32}/');

define('WECHAT_AES_KEY', '/[0-9A-Za-z]{32,64}/');

define('WECHAT_DEVELOPER_MODE', 'developer');
define('WECHAT_EDITOR_MODE', 'editor');
define('WECHAT_MODE', [
    WECHAT_DEVELOPER_MODE,
    WECHAT_EDITOR_MODE
]);

define('GK_APP_NAME', 'greenKey');
define('TO_APP_NAME', 'takeOut');
define('APP_NAME_ARRAY', [
    GK_APP_NAME,
    TO_APP_NAME
]);

define('WECHAT_OFFICIAL_ACCOUNT', 'WECHAT_OFFICIAL_ACCOUNT');
define('WECHAT_OPEN_PLATFORM', 'WECHAT_OPEN_PLATFORM');
define('WECHAT_MINI_PROGRAM', 'WECHAT_MINI_PROGRAM');

define('WECHAT_APP_TYPE', [
    WECHAT_OFFICIAL_ACCOUNT,
    WECHAT_OPEN_PLATFORM,
    WECHAT_MINI_PROGRAM
]);

define('WECHAT_AUTO_REPLY_MESSAGE', [
    WECHAT_IMAGE_MESSAGE,
    WECHAT_VIDEO_MESSAGE,
    WECHAT_VOICE_MESSAGE,
    WECHAT_NEWS_MESSAGE,
    WECHAT_TEXT_MESSAGE
]);


define('SEND_FOCUS_CARD_EVENT', 'send_focus_card_event');

define('SEND_CARD_EVENTS', [
    SEND_FOCUS_CARD_EVENT
]);

define('IP_REGEX', '/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/');

define('CURRENT_APP_PREFIX', 'current_app_id_');

define('DATE_TYPE_FIX_TIME_RANGE', 'DATE_TYPE_FIX_TIME_RANGE');
define('DATE_TYPE_FIX_TERM', 'DATE_TYPE_FIX_TERM');

define('CARD_CHECKING', 0);
define('CARD_PASS_CHECK', 1);
define('CARD_NOT_PASS_CHECK', 2);
define('CARD_INVALID', 3);

define('EVENT_CARD_PASS_CHECK', 'card_pass_check');

define('EVENT_CARD_NOT_PASS_CHECK', 'card_not_pass_check');

define('EVENT_USER_GET_CARD', 'user_get_card');

define('EVENT_USER_SEND_CARD', 'user_gifting_card');

define('EVENT_USER_DELETE_CARD', 'user_del_card');

define('EVENT_USER_CONSUME_CARD', 'user_consume_card');

define('EVENT_USER_PAID', 'User_pay_from_pay_cell');

define('EVENT_USER_VIEW_CARD', 'user_view_card');

define('EVENT_USER_ENTER_SESSION', 'user_enter_session_from_card');

define('EVENT_UPDATE_MEMBER_CARD', 'update_member_card');


define('EVENT_CARD_SKU_REMIND', 'card_sku_remind');


define('EVENT_CARD_PAY_ORDER', 'card_pay_order');

define('EVENT_ACTIVE_MEMBER_CARD', 'submit_membercard_user_info');

// 产品类型
define('BREAKFAST_MERCHANDISE', 'BREAKFAST_MERCHANDISE');// 早餐
define('LUNCH_MERCHANDISE', 'LUNCH_MERCHANDISE');// 午餐
define('DINNER_MERCHANDISE', 'DINNER_MERCHANDISE');// 晚餐
define('UNLIMITED_MERCHANDISE', 'UNLIMITED_MERCHANDISE');
define('MERCHANDISE_STATUS_COLLECTION', [
    BREAKFAST_MERCHANDISE,
    LUNCH_MERCHANDISE,
    DINNER_MERCHANDISE,
    UNLIMITED_MERCHANDISE
]);

// 优惠券投放/使用场景
define('SCENARIO_ALL', 'ALL');
define('CUSTOMER_RANGE_ALL', 'ALL');
define('SCENARIO_SPECIFY', 'SCENARIOS');
define('SCENARIO_ALL_NUM', 0);
define('SCENARIO_MERGE_PAY', 1);
define('SCENARIO_NEIGHBOR', 2);
define('SCENARIO_BOOK_MARKET', 3);
define('TICKET_SCENARIOS', [
    SCENARIO_ALL_NUM => '全场通用',
    SCENARIO_MERGE_PAY => '聚合支付',
    SCENARIO_NEIGHBOR => '邻里优鲜',
    SCENARIO_BOOK_MARKET => '预定商场',
]);
// 优惠券条件类型
define('TICKET_CONDITION_TYPE_USE', 'USE');
define('TICKET_CONDITION_TYPE_PUT', 'PUT');
// 优惠券投放条件LOOP
define('TICKET_LOOP_TYPE_NO_CONDITION', 'NO_CONDITION');
define('TICKET_LOOP_TYPE_SINGLE', 'SINGLE');
define('TICKET_LOOP_TYPE_LOOP', 'LOOP');

define('TEMPLATE_UNDEFINED', 0);
define('TEMPLATE_PAYMENT', 1);
define('TEMPLATE_TICKET_RECEIVE', 2);
define('TEMPLATE_TICKET_OVER_DATE', 3);
define('TEMPLATE_SCORE_RECEIVE', 4);
define('TEMPLATE_SCORE_CONSUME', 5);
// 模板消息类型
define('TEMPLATE_MESSAGE_TYPES', [
    TEMPLATE_UNDEFINED,
    TEMPLATE_PAYMENT,
    TEMPLATE_TICKET_RECEIVE,
    TEMPLATE_TICKET_OVER_DATE,
    TEMPLATE_SCORE_RECEIVE,
    TEMPLATE_SCORE_CONSUME
]);

define('TEMPLATE_PLATFORM_MINIPROGRAM', 'miniprogram');
define('TEMPLATE_PLATFORM_OFFICIAL_ACCOUNT', 'official_account');
define('TEMPLATE_PLATFORMS', [
    TEMPLATE_PLATFORM_MINIPROGRAM,
    TEMPLATE_PLATFORM_OFFICIAL_ACCOUNT
]);

define('WECHAT_TYPE_MINIPROGRAM', 'WECHAT_MINI_PROGRAM');
define('WECHAT_TYPE_OFFICIAL_ACCOUNT', 'WECHAT_OFFICIAL_ACCOUNT');
define('WECHAT_TYPES', [
    WECHAT_TYPE_MINIPROGRAM => 'miniprogram',
    WECHAT_TYPE_OFFICIAL_ACCOUNT => 'official_account'
]);

define('TEMPLATE_SEND_WRONG_TEMPLATE_ID', 40037);
define('TEMPLATE_SEND_INVALID_FORMID', 41028);
define('TEMPLATE_SEND_USED_FORMID', 41029);
define('TEMPLATE_SEND_WRONG_PAGE', 41030);
define('TEMPLATE_SEND_OVER_LIMIT', 45009);
define('TEMPLATE_SEND_ERRCODE', [
    TEMPLATE_SEND_WRONG_TEMPLATE_ID => 'template_id不正确',
    TEMPLATE_SEND_INVALID_FORMID => 'form_id不正确，或者过期',
    TEMPLATE_SEND_USED_FORMID => 'form_id已被使用',
    TEMPLATE_SEND_WRONG_PAGE => 'page不正确',
    TEMPLATE_SEND_OVER_LIMIT => '接口调用超过限额（目前默认每个帐号日调用限额为100万）',
]);

define('PAYMENT_TYPE_ALI', 'ALI');
define('PAYMENT_TYPE_WX', 'WX');
define('PAYMENT_TYPE_OTHER', 'other');

