<?php

namespace App\Http\Controllers\MiniProgram;

use Payment\NotifyContext;

class PaymentController extends Controller
{

    public function notify()
    {
        $notify = app('payment.wechat.notify');
        $data = $notify->notify($this->app->make('payment.notify'));
        return $this->response($data);
    }
}