<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use Helpers;
    protected $session = null;

    protected $currentWechat = null;

    public function __construct()
    {
        $this->currentWechat = app('current_wechat');
    }

    protected function response($data = null)
    {
        return $data ? $this->response->created()->setContent($data) : app('api.http.response');
    }

    public function getList(){

    }
}
