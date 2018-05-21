<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Log;

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
            $this->app->make('api.exception')->register(function (HttpException $exception){
                $response['status_code'] = $exception->getStatusCode();
                $response['message'] = $exception->getMessage();
                switch($exception->getStatusCode()){
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
                return (new Response( $response));
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
