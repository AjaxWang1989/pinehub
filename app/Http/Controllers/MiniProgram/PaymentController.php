<?php

namespace App\Http\Controllers\MiniProgram;

use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Payment\NotifyContext;

class PaymentController extends Controller
{

    public function notify(Request $request, string $token = null)
    {
        Log::info('--------------------- payment notify------------------------------------',
            [$_POST, $request->all(), @file_get_contents('php://input')]);
        $data = null;
        if($token) {
            $token = Cache::get($token);
            if(app('tymon.jwt.auth')->authenticate($token)) {
                $notify = app('payment.wechat.notify');
                $data = $notify->notify(app('payment.notify'));
            }
        }
        Log::info('------- notify -----', [$data]);
        return $this->response($data);
    }
}