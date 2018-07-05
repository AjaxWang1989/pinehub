<?php

namespace App\Providers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;


class ApiExceptionHandlerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if($this->app->has('api.exception')){
            $this->app->make('api.exception')->register(function (\Exception $exception) {
                $responseSender = new Response();
                //header(sprintf('HTTP/%s %s %s', $responseSender->getProtocolVersion(), $this->, $this->statusText), true, $this->statusCode);
                header('Access-Control-Allow-Origin:*');
                header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, Accept');
                header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, DELETE, OPTIONS');
                header('Access-Control-Allow-Credentials:true');
                header('', '');
                if(Request::method() === HTTP_METHOD_OPTIONS) {
                    exit();
                }
                $response['status_code'] = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
                $response['message'] = $exception->getMessage();
                $response['errors'] = method_exists($exception, 'getErrors') ? $exception->getErrors() : null;
                $response['errors'] = method_exists($exception, 'errors') ? $exception->errors() : null;
                if($exception instanceof AuthorizationException) {
                    $response['status_code'] = 401;
                }
                switch($response['status_code']){
                    case HTTP_STATUS_BAD_REQUEST:{
                        if(!$response['message'] ){
                            $response['message']  = "客户端请求有误";
                        }
                        break;
                    }
                    case HTTP_STATUS_UNAUTHORIZED: {
                        if(!$response['message']){
                            $response['message'] = "登陆失败，或者未登录权限不足，请重新登陆";
                        }
                        break;
                    }
                    case HTTP_STATUS_PAYMENT_REQUIRED:{
                        if(!$response['message']){
                            $response['message'] = "预留字段暂未定义";
                        }
                        break;
                    }
                    case HTTP_STATUS_FORBIDDEN:{
                        if(!$response['message']){
                            $response['message'] = "资源受限，禁止访问";
                        }
                        break;
                    }
                    case HTTP_STATUS_NOT_FOUND:{
                        if(!$response['message']){
                            $response['message'] = "资源不存在无法访问";
                        }
                        break;
                    }
                }

                exit($responseSender->getContent());
                //return $responseSender->setContent($response)->send();
            });
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
