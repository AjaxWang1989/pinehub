<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/3
 * Time: 下午4:33
 */

namespace App\Http\Controllers\MiniProgram;


use App\Http\Controllers\Controller;
use App\Repositories\WechatUserRepositoryEloquent;

class AuthController extends  Controller
{
    /**
     * @var WechatUserRepositoryEloquent
     * */
    protected $wechatUserRepository = null;

    public function login(string $code) {
        $mpSession = app('wechat')->miniProgram()->auth->session($code);
        if($mpSession && ($wechatUser = $this->wechatUserRepository->findByField('open_id', $mpSession['openid']))) {

            //return //;
        }
    }
}