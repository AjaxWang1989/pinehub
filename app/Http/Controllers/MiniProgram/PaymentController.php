<?php

namespace App\Http\Controllers\MiniProgram;

use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Payment\NotifyContext;

class PaymentController extends Controller
{

    public function notify(Request $request)
    {
        Log::info('--------------------- payment notify------------------------------------',
            $request->all());
        $data = null;
        if(($token = $request->input('token', null))) {
            $token = Cache::get($token);
            if(app('tymon.jwt.auth')->authenticate($token)) {
                $notify = app('payment.wechat.notify');
                $data = $notify->notify($this->app->make('payment.notify'));
            }
        }

        return $this->response($data);
    }
}