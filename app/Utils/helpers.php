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