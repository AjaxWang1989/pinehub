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

define('PASSWORD_PATTERN','/^[a-zA-Z0-9\@\!\$\&\%]{6,20}/');

define('USER_NAME_MAX_LENGTH', 64);

define('UNKNOWN', 'UNKNOWN');

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
define('SHOP_CODE_FORMAT', 'Ymd');
define('SHOP_CODE_SEGMENT_MAX_LENGTH', 100);

define('ONE_DAY_SECONDS', 86400);

define('USER_AUTH_BASE', 'user_base');
define('USER_AUTH_INFO', 'user_info');

define('MEMBER_CARD', 'member_card');

define('COUPON_CARD', 'coupon_card');
define('GROUPON_CARD', 'groupon');
define('DISCOUNT_CARD', 'discount');

define('WECHAT_TEXT_MESSAGE', 'text');

define('WECHAT_IMAGE_MESSAGE', 'image');

define('WECHAT_VOICE_MESSAGE', 'voice');

define('WECHAT_EVENT_MESSAGE', 'event');

define('WECHAT_NEWS_MESSAGE', 'news');

define('WECHAT_VIDEO_MESSAGE', 'video');

define('WECHAT_MUSIC_MESSAGE', 'music');

define('VIEW_BUTTON', 'view');

define('CLICK_BUTTON', 'click');

define('MP_BUTTON', 'miniprogram');

