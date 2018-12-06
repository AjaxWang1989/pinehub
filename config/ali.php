<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/23
 * Time: 上午9:50
 */
return [
    'OSS' => [

    ],
    'payment' => [
        'use_sandbox'               => env('ALI_PAYMENT_SANDBOX', false),// 是否使用沙盒模式

        'app_id'                    => env('ALI_PAYMENT_APPID', '2018051860101849'),
        'sign_type'                 => env('ALI_PAYMENT_SIGN_TYPE', 'RSA2'),// RSA  RSA2
        'md5_key'                   => env('ALI_PAYMENT_MD5_KEY', 'zismisutln32vdlavqdg7brqmya9z3ts'),

        // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN PUBLIC KEY----- 这种标记
        // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
        'ali_public_key'            => storage_path(env('ALI_PAYMENT_PUBLIC_KEY_PATH', '/private/ali/sandbox/public.key')),

        // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN RSA PRIVATE KEY----- 这种标记
        // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
        'rsa_private_key'           => storage_path(env('ALI_PAYMENT_PRIVATE_KEY_PATH', '/private/ali/sandbox/private.key')),
        'limit_pay'                 => [
            //'balance',// 余额
            //'moneyFund',// 余额宝
            //'debitCardExpress',// 	借记卡快捷
            //'creditCard',//信用卡
            //'creditCardExpress',// 信用卡快捷
            //'creditCardCartoon',//信用卡卡通
            //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
        ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

        // 与业务相关参数
        'notify_url'                => '',//webUriGenerator(env('ALI_PAYMENT_NOTIFY_URL', '/payment/ali//notify'), env('WEB_PAYMENT_PREFIX'), env('WEB_DOMAIN')),
        'return_url'                => '',//webUriGenerator(env('ALI_PAYMENT_RETURN_URL', '/payment/ali/success'), env('WEB_PAYMENT_PREFIX'), env('WEB_DOMAIN')),
        'redirect_url'              => '',//webUriGenerator(env('ALi_PAYMENT_REDIRECT_URL', '/ali'), env('WEB_OAUTH_PREFIX'), env('WEB_DOMAIN')),// 如果是h5支付，可以设置该值，返回到指定页面
        'return_raw'                => env('ALI_PAYMENT_RETURN_RAW', false),// 在处理回调时，是否直接返回原始数据，默认为 true
    ],
    'mini_program' => [
        'use_sandbox'               => env('ALI_PAYMENT_SANDBOX', false),// 是否使用沙盒模式
        'aes_key'                   => env('ALI_MP_AES_KEY', 'FPzyBatgXp8IvEPUzVVD5A=='),
        'app_id'                    => env('ALI_MINI_PROGRAM_APPID', '2018051860101849'),
        'sign_type'                 => env('ALI_PAYMENT_SIGN_TYPE', 'RSA2'),// RSA  RSA2
        'md5_key'                   => env('ALI_PAYMENT_MD5_KEY', 'zismisutln32vdlavqdg7brqmya9z3ts'),

        // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN PUBLIC KEY----- 这种标记
        // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
        'ali_public_key'            => storage_path(env('ALI_PAYMENT_PUBLIC_KEY_PATH', '/private/ali/mp/public.key')),

        // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN RSA PRIVATE KEY----- 这种标记
        // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
        'rsa_private_key'           => storage_path(env('ALI_PAYMENT_PRIVATE_KEY_PATH', '/private/ali/mp/private.key')),
        'limit_pay'                 => [
            //'balance',// 余额
            //'moneyFund',// 余额宝
            //'debitCardExpress',// 	借记卡快捷
            //'creditCard',//信用卡
            //'creditCardExpress',// 信用卡快捷
            //'creditCardCartoon',//信用卡卡通
            //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
        ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

        // 与业务相关参数
        'notify_url'                => '',
        'return_url'                => '',
        'redirect_url'              => '',// 如果是h5支付，可以设置该值，返回到指定页面
        'return_raw'                => env('ALI_PAYMENT_RETURN_RAW', false),// 在处理回调时，是否直接返回原始数据，默认为 true

    ]
];