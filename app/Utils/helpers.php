<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/16
 * Time: 上午9:32
 */
if (!function_exists('toUserModel')) {
    function toUserModel($user): \App\Entities\User
    {
        return $user;
    }
}
if (!function_exists('upperCaseSplit')) {
    function upperCaseSplit(string $des, string $delimiter = ' ')
    {
        $strArr = preg_split('/(?=[A-Z])/', $des);
        if (count($strArr) <= 1) {
            return $des;
        }
        return strtolower(implode($strArr, $delimiter));
    }
}

if (!function_exists('laravelToLumen')) {
    function laravelToLumen($application): \Laravel\Lumen\Application
    {
        return $application;
    }
}


if (!function_exists('bootstrapPath')) {
    function bootstrapPath(): string
    {
        return app()->basePath('/bootstrap');
    }
}

if (!function_exists('cachePath')) {
    function cachePath($path = ""): string
    {
        return app()->basePath('/storage/framework/cache' . $path);
    }
}

if (!function_exists('configCachePath')) {
    function configCachePath()
    {
        return bootstrapPath() . '/cache/config.php';
    }
}

if (!function_exists('servicesCachePath')) {
    function servicesCachePath()
    {
        return bootstrapPath() . '/cache/services.php';
    }
}

if (!function_exists('environmentFilePath')) {
    function environmentFilePath(): string
    {
        return app()->basePath('/.env');
    }
}


if (!function_exists('setAliases')) {
    function setAliases(array $aliases, \Laravel\Lumen\Application $app)
    {
        foreach ($aliases as $alias => $abstract) {
            $app->alias($abstract, $alias);
        }
    }
}

if (!function_exists('config_path')) {
    function config_path(string $path)
    {
        app()->getConfigurationPath($path);
    }
}

if (!function_exists('mobileCompany')) {
    function mobileCompany(string $mobile)
    {
        if (preg_grep(CM_MOBILE_PATTERN, [$mobile])) {
            return CHINA_MOBILE;
        } elseif (preg_grep(CT_MOBILE_PATTERN, [$mobile])) {
            return CHINA_TEL;
        } elseif (preg_grep(CU_MOBILE_PATTERN, [$mobile])) {
            return CHINA_UNION;
        } else {
            return UNKNOWN;
        }
    }
}

if (!function_exists('isMobile')) {
    function isMobile(string $mobile)
    {
        if (preg_grep(MOBILE_PATTERN, [$mobile])) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('password')) {
    function password(string $before, bool $handle = false)
    {
        return \Illuminate\Support\Facades\Hash::make($handle ? $before : md5($before . config('app.public_key')), [
            'slat' => config('app.private_key')
        ]);
    }
}

if (!function_exists('generatorUID')) {
    function generatorUID(string $prefix, string $suffix = '')
    {
        return $prefix . $suffix;
    }
}

if (!function_exists('buildUrl')) {
    function buildUrl(string $gateway, $path, array $params = [], array $query = [], string $proto = 'http://')
    {
        foreach ($params as $key => $param) {
            $search[] = '/({' . $key . '})|({' . $key . '\?})/';
            $replace[] = $param;
        }
        if(\Illuminate\Support\Facades\Request::secure()){
            $proto = 'https://';
        }
        if (isset($search) && isset($replace)) {

            $path = preg_replace($search, $replace, $path);
            //\Illuminate\Support\Facades\Log::debug('--------', ['search' => $search, 'replace' => $replace, 'path' => $path]);
        }

        if ($path) {
            $path = trim($path, '/');
            $host = trim(gateway($gateway), '/');
            $query = http_build_query($query);
            $query = $query ? '?' . $query : '';
            return $proto . $host . '/' . $path . $query;
        } else {
            return null;
        }
    }
}

if (!function_exists('apiUrlGenerator')) {
    function apiUrlGenerator(string $gateway, string $name, array $params = [], array $query = [], string $version = null)
    {
        $router = app('api.router');
        /** @var \Dingo\Api\Routing\RouteCollection $routes */
        $routes = $router->getRoutes($version);
        \Illuminate\Support\Facades\Log::debug('---------- routes ----------', $router);
        $search = [];
        $replace = [];
        $url = null;
        foreach ($params as $key => $param) {
            $search[] = '/({' . $key . '})|({' . $key . '?})/';
            $replace[] = $param;
        }
        foreach ($routes as $route) {
            $url = value(function () use ($name, $search, $replace, $route) {
                $routeUri = $route->uri();
                $routeName = $route->getName();
                if ($name === $routeName) {
                    return preg_replace($search, $replace, $routeUri);
                }
                return null;
            });
            if ($url) {
                $url = trim($url, '/');
                break;
            }
        }

        if ($url) {
            return gateway($gateway) . '/' . $url . '?' . http_build_query($query);
        } else {
            return null;
        }
    }
}

if (!function_exists('webUrlGenerator')) {
    function webUrlGenerator(string $gateway, string $name, array $params = [], array $query = [])
    {
        $router = app()->router;
        $routes = $router->namedRoutes;
        $search = [];
        $replace = [];
        $url = null;
        foreach ($params as $key => $param) {
            $search[] = '/({' . $key . '})|({' . $key . '?})/';
            $replace[] = $param;
        }
        foreach ($routes as $routeName => $routeUri) {
            if ($name === $routeName) {
                $url = preg_replace($search, $replace, $routeUri);
            }
            if ($url) {
                $url = trim($url, '/');
                break;
            }
        }

        if ($url) {
            return gateway($gateway) . '/' . $url . '?' . http_build_query($query);
        } else {
            return null;
        }
    }
}

if (!function_exists('jsonResponse')) {
    function jsonResponse($content, $statusCode = 200)
    {
        $response = app(\Dingo\Api\Http\Response\Factory::class)->created();
        $response->setContent(['data' => $content]);
        $response->setStatusCode($statusCode);
        return $response;
    }
}

if (!function_exists('multi_array_merge')) {
    function multi_array_merge(array $array1, array $array2 = null)
    {
        $count = func_num_args();
        if ($count === 0) {
            return null;
        } elseif ($count === 1) {
            return $array1;
        } else {
            foreach ($array2 as $key => $value) {
                if (isset($array1[$key])) {
                    if (is_array($value) && is_array($array1[$key])) {
                        $value = multi_array_merge($array1[$key], $array2[$key]);
                    }
                }
                $array1[$key] = $value;
            }
        }
        return $array1;
    }
}

if (!function_exists('gateway')) {
    function gateway(string $gateway)
    {
        $gatewayConfig = config('gateway.' . $gateway);
        $tmp = explode('.', $gateway);
        if ($tmp[0] === 'api') {
            $gateway = app('api.gateways');
        } else {
            $gateway = app('web.gateways');
        }

        return $gateway->getGateway($gatewayConfig);
    }
}

if (!function_exists('domainAndPrefix')) {
    function domainAndPrefix(\Illuminate\Http\Request $request)
    {
        $domain = $request->getHost();
        $domains = explode('.', $domain);
        $www = '';
        if ($domains[0] === 'www') {
            array_shift($domains);
            $www = 'www.';
        }
        $domain = implode('.', $domains);
        $path = $request->path();
        $tmp = explode('/', $path);
        $prefix = $tmp[0];
        return [$www, $domain, $prefix];
    }
}

if (!function_exists('is_assoc')) {
    function is_assoc($array)
    {
        if (is_array($array)) {
            $keys = array_keys($array);
            $diff = array_diff($keys, array_keys($keys));
            return !$diff || count($diff) === 0;
        }
        return false;
    }
}

if (!function_exists('config_path')) {
    /* Get the configuration path. @param string $path @return string */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
