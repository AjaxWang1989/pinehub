<?php

namespace App\Http\Controllers\MiniProgram;

use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use Payment\NotifyContext;

class PaymentController extends Controller
{

    public function notify(Request $request)
    {
        Log::info('--------------------- payment notify------------------------------------',
            $request->all());
        $notify = app('payment.wechat.notify');
        $data = $notify->notify($this->app->make('payment.notify'));
        return $this->response($data);
    }
}