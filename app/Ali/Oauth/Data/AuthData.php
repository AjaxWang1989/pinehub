<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:53
 */

namespace App\Ali\Oauth\Data;


use Illuminate\Support\Facades\Log;
use Payment\Common\Ali\Data\Charge\ChargeBaseData;
use Payment\Common\PayException;


/**
 * @property $scopes
 * @property $state
 * */
class AuthData extends ChargeBaseData
{
    /**
     * 业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递
     *
     * @return string
     */
    protected function getBizContent()
    {
        $content = [
           'scopes' => $this->scopes,
            'state' => $this->state
        ];

        return $content;
    }

    protected function checkDataParam()
    {
       if(!in_array($this->scopes, ['auth_base', 'auth_user'])){
           throw new PayException('scope错误');
       }
       Log::debug('state '.$this->state);
       if(!isset($this->state)){
           //throw new PayException('state错误');
       }
    }
}