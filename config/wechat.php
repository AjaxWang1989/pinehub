<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 默认配置，将会合并到各模块中
     */
    'defaults' => [
        /*
         * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
         */
        'response_type' => 'array',

        /*
         * 使用 Laravel 的缓存系统
         */
        'use_laravel_cache' => true,

        /*
         * 日志配置
         *
         * level: 日志级别，可选为：
         *                 debug/info/notice/warning/error/critical/alert/emergency
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
        ],
    ],

    /*
     * 路由配置
     */
    'route' => [
        /*
         * 开放平台第三方平台路由配置
         */
        // 'open_platform' => [
        //     'uri' => 'serve',
        //     'action' => Overtrue\LaravelWeChat\Controllers\OpenPlatformController::class,
        //     'attributes' => [
        //         'prefix' => 'open-platform',
        //         'middleware' => null,
        //     ],
        // ],
    ],

    /*
     * 公众号
     */
    'official_account' => [
        'default' => [
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'wx581a7ad7ca810da6'),         // AppID
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', '1b6df1bd03c8a41fb41cecaff1492532'),    // AppSecret
            'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'your-token'),           // Token
            'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey

            /*
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
             */
             'oauth' => [
                 'scopes'   => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
                 'callback' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
             ],
        ],
    ],

    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //         'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //         'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 小程序
     */
     'mini_program' => [
         'default' => [
             'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', 'wx67127c10ce9c598c'),
             'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', 'd96b9a53551391805e79447d79f96499'),
             'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
             'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
         ],
     ],

    /*
     * 微信支付
     */
     'payment' => [
         'default' => [
             'sandbox'            => env('WECHAT_PAYMENT_SANDBOX', false),
             'app_id'             => env('WECHAT_PAYMENT_APPID', 'wx581a7ad7ca810da6'),
             'mch_id'             => env('WECHAT_PAYMENT_MCH_ID', '1502557441'),
             'key'                => env('WECHAT_PAYMENT_KEY', 'e4c7096983336907b9e04fd1489de954'),
             'cert_path'          => storage_path(env('WECHAT_PAYMENT_CERT_PATH', '/wechat/cert/apiclient_cert.pem')),    // XXX: 绝对路径！！！！
             'key_path'           => storage_path(env('WECHAT_PAYMENT_KEY_PATH', '/wechat/cert/apiclient_key.pem')),      // XXX: 绝对路径！！！！
             'notify_url'         => paymentApiUriGenerator('/wechat/payment/notify'),                           // 默认支付结果通知地址
         ],
     ],

    /*
     * 企业微信
     */
    // 'work' => [
    //     'default' => [
    //         'corp_id' => 'xxxxxxxxxxxxxxxxx',
    ///        'agent_id' => 100020,
    //         'secret'   => env('WECHAT_WORK_AGENT_CONTACTS_SECRET', ''),
    //          //...
    //      ],
    // ],

    //other sdk payment
    'other_sdk_payment' => [
        'use_sandbox'            => env('WECHAT_PAYMENT_SANDBOX', false),
        'app_id'             => env('WECHAT_PAYMENT_APPID', 'wx581a7ad7ca810da6'),
        'mch_id'             => env('WECHAT_PAYMENT_MCH_ID', '1502557441'),
        'md5_key'                => env('WECHAT_PAYMENT_KEY', 'e4c7096983336907b9e04fd1489de954'),
        'app_cert_pem'          => storage_path(env('WECHAT_PAYMENT_CERT_PATH', 'app/wechat/cert/apiclient_cert.pem')),    // XXX: 绝对路径！！！！
        'app_key_pem'           => storage_path(env('WECHAT_PAYMENT_KEY_PATH', 'app/wechat/cert/apiclient_key.pem')),      // XXX: 绝对路径！！！！
        'sign_type'         => env('WECHAT_PAYMENT_SIGN_TYPE', 'MD5'),// MD5  HMAC-SHA256
        'limit_pay'         => [
            //'no_credit',
        ],// 指定不能使用信用卡支付   不传入，则均可使用
        'fee_type'          => env('WECHAT_PAYMENT_FEE_TYPE', 'CNY'),// 货币类型  当前仅支持该字段
        'notify_url'        => webUriGenerator(env('WECHAT_PAYMENT_NOTIFY_URL', '/payment/wechat/notify'), env('WEB_PAYMENT_PREFIX'), env('WEB_DOMAIN')),
        'redirect_url'      => webUriGenerator(env('WECHAT_PAYMENT_REDIRECT_URL', '/wechat/aggregate.html'), env('WEB_PAYMENT_PREFIX'), env('WEB_DOMAIN')),// 如果是h5支付，可以设置该值，返回到指定页面
        'return_raw'        => env('WECHAT_PAYMENT_RETURN_RAW', false),// 在处理回调时，是否直接返回原始数据，默认为true
    ]
];
