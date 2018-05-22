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
       Log::debug('state ', [$this->state, isset($this->state)]);
       if(!isset($this->state)){
           //throw new PayException('state错误');
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
            'return_url'    => $this->returnUrl,

            // 业务参数
            'biz_content'   => json_encode($bizContent, JSON_UNESCAPED_UNICODE),
        ];

//        // 电脑支付  wap支付添加额外参数
//        if (in_array($this->method, ['alipay.trade.page.pay', 'alipay.trade.wap.pay'])) {
//            $signData['return_url'] = $this->returnUrl;
//        }

        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }
}