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
    protected $currentOfficialAccount = null;

    /**
     * @var WechatConfig
     * */
    protected $currentMiniProgram = null;


    public function __construct()
    {
        $this->currentOfficialAccount = app('current_official_account');
        $this->currentMiniProgram = app('current_mini_program');
    }

    protected function response($data = null)
    {
        return $data ? $this->response->created()->setContent($data) : app('api.http.response');
    }

    public function getList(){

    }
}
