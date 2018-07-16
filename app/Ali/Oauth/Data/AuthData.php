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
use Payment\Utils\ArrayUtil;


/**
 * @property $scopes
 * @property $state
 * @property $redirect_uri
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
            'scope' => implode(',', $this->scopes),
            'state' => $this->state
        ];
        if($this->redirect_uri){
            $content['redirect_uri'] = $this->redirect_uri;
        }

        return $content;
    }

    protected function checkDataParam()
    {
        if(!is_array($this->scopes)) {
            $this->scopes = explode(',', $this->scopes);
        }
        Log::debug('scopes', [$this->scopes]);
        foreach ($this->scopes as $scope){
            if(!in_array($scope, ['auth_base', 'auth_user'])){
                throw new PayException('scope错误');
            }
        }

       if($this->state === null){
           throw new PayException('state错误');
       }
    }


    /**
     * 构建 支付 加密数据
     * @author helei
     */
    protected function buildData()
    {
        $bizContent = $this->getBizContent();
        $bizContent = ArrayUtil::paraFilter($bizContent);// 过滤掉空值，下面不用在检查是否为空

        $signData = [
            // 公共参数
            'app_id'        => $this->appId,
        ];
        $signData = array_merge($signData, $bizContent);
        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }
}