<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/8/21
 * Time: 上午10:33
 */
return [
    'api_domain' => env('API_DOMAIN', 'api.kingdoucloud.cn'),
    'web_domain' => env('WEB_DOMAIN', 'kingdoucloud.cn'),
    'api' => [
        'h5' => env('H5_API_GATEWAY', 'h5'),
        'mp' => env('MP_API_GATEWAY', 'mp'),
        'auth' => env('AUTH_API_GATEWAY', 'auth'),
        'backend' => env('BACKEND_API_GATEWAY', 'backend')
    ],
    'web' => [
        'image' => env('IMAGE_WEB_GATEWAY', 'image'),
        'oauth' => env('OAUTH_WEB_GATEWAY', 'oauth'),
        'wxopen' => env('WECHAT_OPEN_PLATFORM_WEB_GATEWAY', 'wxopen'),
        'h5' => env('H5_WEB_GATEWAY', 'h5'),
        'wxMp' => env('WX_MP_WEB_GATEWAY', 'wx.mp'),
        'aliMp' => env('ALI_MP_WEB_GATEWAY', 'ali.mp')
    ]
];