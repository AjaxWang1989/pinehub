<?php

namespace App\Http\Controllers;

use App\Http\Resources\WechatConfig;
use Dingo\Api\Routing\Helpers;
use Illuminate\Session\SessionManager;
use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use Helpers;

    /**
     * @var SessionManager
     * */
    protected $session ;

    /**
     * @var WechatConfig
     * */
    protected $currentOfficialAccount;

    /**
     * @var WechatConfig
     * */
    protected $currentMiniProgram;

    protected $wechat = null;


    public function __construct()
    {
        $this->currentOfficialAccount = app('current_official_account');
        $this->currentMiniProgram = app('current_mini_program');
        $this->wechat = app('wechat');
        $this->session = app()->has('session') ?  app('session') : null;
    }

    protected function response($data = null)
    {
        return $data ? $this->response->created()->setContent($data) : app('api.http.response');
    }

    public function getList(){

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->response = null;
        $this->user = null;
        $this->currentOfficialAccount = null;
        $this->currentMiniProgram = null;
        $this->auth = null;
        $this->session = null;
        $this->scopes = null;
        $this->api = null;
        $this->middleware = null;
        $this->rateLimit = null;
        $this->throttles = null;
        $this->authenticationProviders = null;
        $this->wechat = null;
        $this->session = null;
    }
}
