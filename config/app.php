<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/13
 * Time: 上午10:32
 */
return [
    /*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| This key is used by the Illuminate encrypter service and should be set
| to a random, 32 character string, otherwise these encrypted strings
| will not be safe. Please do this before deploying an application!
|
*/

    'key' => env('APP_KEY', 'SomeRandomString!!!'),
    'public_key' => env('APP_PUBLIC_KEY', 'SomeRandomString!!!'),
    'private_key' => env('APP_PRIVATE_KEY', 'SomeRandomString!!!'),

    'cipher' => 'AES-256-CBC',
    'web_domain' =>  env('WEB_DOMAIN', 'site.pinehub'),
    'payment_api_domain' => env('PAYMENT_API_DOMAIN', 'api.payment.pinehub'),
    'web_prefix' => env('WEB_PREFIX', ''),

    'protocol' => env('WEB_PROTO', 'http://'),
    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'alias' => [
        'App' => 'Illuminate\Support\Facades\App',
        'Auth' => 'Illuminate\Support\Facades\Auth',
        'Bus' => 'Illuminate\Support\Facades\Bus',
        'DB' => 'Illuminate\Support\Facades\DB',
        'Cache' => 'Illuminate\Support\Facades\Cache',
        'Cookie' => 'Illuminate\Support\Facades\Cookie',
        'Crypt' => 'Illuminate\Support\Facades\Crypt',
        'Event' => 'Illuminate\Support\Facades\Event',
        'Hash' => 'Illuminate\Support\Facades\Hash',
        'Log' => 'Illuminate\Support\Facades\Log',
        'Mail' => 'Illuminate\Support\Facades\Mail',
        'Queue' => 'Illuminate\Support\Facades\Queue',
        'Request' => 'Illuminate\Support\Facades\Request',
        'Schema' => 'Illuminate\Support\Facades\Schema',
        'Session' => 'Illuminate\Support\Facades\Session',
        'Storage' => 'Illuminate\Support\Facades\Storage',
        'JWTAuth' => '\Tymon\JWTAuth\Facades\JWTAuth',
        'EasyWeChat' => '\Overtrue\LaravelWeChat\Facade',
        //'Validator' => 'Illuminate\Support\Facades\Validator',
        'auth.meta' => '\App\Http\Middleware\ResponseMetaAddToken'
    ]
];