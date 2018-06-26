<?php

namespace App\Http\Controllers;

use App\Services\Wechat\WechatService;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Session\Session;
use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use Helpers;

    /**
     * @var Session|null
     * */
    protected $session = null;

    /**
     * @var WechatService
     * */
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
