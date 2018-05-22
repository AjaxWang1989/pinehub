<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/16
 * Time: 上午9:32
 */
if(!function_exists('toUserModel')){
    function toUserModel($user) : \App\Entities\User
    {
        return $user;
    }
}
if(!function_exists('upperCaseSplit')){
    function upperCaseSplit(string $des, string $delimiter = ' ')
    {
        $strArr = preg_split('/(?=[A-Z])/', $des);
        if(count($strArr) <= 1){
            return $des;
        }
        return strtolower(implode($strArr, $delimiter));
    }
}

if(!function_exists('laravelToLumen')){
    function laravelToLumen($application) : \Laravel\Lumen\Application
    {
        return $application;
    }
}


if(!function_exists('bootstrapPath')){
    function bootstrapPath() : string
    {
        return app()->basePath('/bootstrap');
    }
}

if(!function_exists('cachePath')){
    function cachePath($path = "") : string
    {
        return app()->basePath('/storage/framework/cache'.$path);
    }
}

if(!function_exists('configCachePath')){
    function configCachePath()
    {
        return bootstrapPath().'/cache/config.php';
    }
}

if(!function_exists('servicesCachePath')){
    function servicesCachePath()
    {
        return bootstrapPath().'/cache/services.php';
    }
}

if(!function_exists('environmentFilePath')){
    function environmentFilePath() : string
    {
        return app()->basePath('/.env');
    }
}


if(!function_exists('setAliases')){
    function setAliases(array $aliases)
    {
        foreach ($aliases as $key => $alias){
            app()->alias($key, $alias);
        }
    }
}

if(!function_exists('config_path')){
    function config_path(string $path)
    {
        app()->getConfigurationPath($path);
    }
}

if(!function_exists('mobileCompany')){
    function mobileCompany(string $mobile)
    {
        if(preg_grep(CM_MOBILE_PATTERN, $mobile)){
            return CHINA_MOBILE;
        }elseif (preg_grep(CT_MOBILE_PATTERN, $mobile)){
            return CHINA_TEL;
        }elseif (preg_grep(CU_MOBILE_PATTERN, $mobile)){
            return CHINA_UNION;
        }else{
            return UNKNOWN;
        }
    }
}

if(!function_exists('password')){
    function password(string  $before, bool $handle = false){
        return \Illuminate\Support\Facades\Hash::make($handle ? $before : md5($before.config('app.public_key')), [
            'slat' => config('app.private_key')
        ]);
    }
}

if(!function_exists('generatorUID')){
    function generatorUID (string $prefix) {
        $now = \Illuminate\Support\Carbon::now();
        $formatDate = $now->format('YmdHisu');
        return $prefix.$formatDate;
    }
}

if(!function_exists('webUriGenerator')) {
    function webUriGenerator(string $route, string $prefix = '') {
        if(!$prefix){
            $prefix = (config('app.web_prefix') ? '/'.config('app.web_prefix') : '');
        }
        if(substr($prefix, 0, 1) !== '/'){
            $prefix = '/'.$prefix;
        }
        return config('app.protocol').config('app.web_domain').$prefix.$route;
    }
}

if(!function_exists('paymentApiUriGenerator')) {
    function paymentApiUriGenerator(string $route){
        return config('app.protocol').config('app.payment_api_domain').(env('PAYMENT_API_PREFIX')? '/'.env('PAYMENT_API_PREFIX') : '').$route;
    }
}

if(!function_exists('domainAndPrefix')) {
    function domainAndPrefix (\Illuminate\Http\Request $request) {
        $domain = $request->getHost();
        $domains = explode('.', $domain);
        if($domains[0] === 'www')
        {
            array_shift($domains);
        }
        $domain = implode('.', $domains);
        $path = $request->path();
        $tmp = explode('/', $path);
        $prefix = $tmp[0];
        return [$domain, $prefix];
    }
}
