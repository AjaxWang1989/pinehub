<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/9
 * Time: 16:12
 */

namespace App\Http\Middleware;


class SetPaymentConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $type
     * @return mixed
     */
    public function handle($request, \Closure $next, string $type = null)
    {
        $notifyUrl = $request->url();
        config(['wechat.other_sdk_payment.notify_url' => $notifyUrl]);
        return $next($request);
    }
}