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

define('PASSWORD_PATTERN','/^[a-zA-Z0-9\@\!\$\&\%]{5,20}/');

define('USER_NAME_MAX_LENGTH', 64);

define('UNKNOWN', 'UNKNOWN');

define('MALE', 'MALE');

define('FEMALE', 'FEMALE');

define('IMAGE_URL_PATTERN', '/^(http|https):\/\/(.*)\.(gif|jpg|GIF|JPG|png)$/');

define('CHINA_MOBILE', '中国移动');

define('CHINA_UNION', '中国联通');

define('CHINA_TEL', '中国电信');

define('PAGE_LIMIT', 15);