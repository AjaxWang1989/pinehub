<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/23
 * Time: 上午9:18
 */

namespace App\Ali\Oauth\Data;


use Payment\Common\Ali\Data\Charge\ChargeBaseData;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * @property $grant_type
 * @property $code
 * @property $refresh_token
 * */
class TokenData extends ChargeBaseData
{
    /**
     * 业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递
     *
     * @return string
     */
    protected function getBizContent()
    {
        $content = [];
        $content['grant_type'] = $this->grant_type;
        if(isset($this->code))
            $content['code'] = $this->code;
        if(isset($this->refresh_token))
            $content['refresh_token'] = $this->refresh_token;

        return $content;
    }

    protected function checkDataParam()
    {
        if(!in_array($this->grant_type, ['authorization_code', 'refresh_token'])){
            throw new PayException('grant_type错误');
        }

        if($this->grant_type === 'authorization_code' && !$this->code){
           throw new PayException('authorization_code没有code');
        }

        if($this->grant_type === 'refresh_token' && !$this->refresh_token){
            throw new PayException('refresh_token没有对应的refresh_token');
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
            'method'        => $this->method,
            'format'        => $this->format,
            'charset'       => $this->charset,
            'sign_type'     => $this->signType,
            'timestamp'     => $this->timestamp,
            'version'       => $this->version,
        ];
        $signData = array_merge($signData, $bizContent);
        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }
}