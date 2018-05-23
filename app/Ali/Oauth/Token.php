<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:48
 */

namespace App\Ali\Oauth;


use App\Ali\Oauth\Data\TokenData;
use Payment\Common\Ali\AliBaseStrategy;

class Token extends AliBaseStrategy
{
    protected $method = 'alipay.system.oauth.token';

    /**
     * 获取支付对应的数据完成类
     * @return string
     * @author helei
     */
    public function getBuildDataClass()
    {
        $this->config->method = $this->method;
        // 以下两种方式任选一种
        return TokenData::class;
    }

    /**
     * 返回可发起h5支付的请求
     * @param array $data
     * @return array
     * @throws
     */
    protected function retData(array $data)
    {
        $requestData = parent::retData($data);

        try {
            $res = $this->sendReq($requestData);
        } catch (PayException $e) {
            throw $e;
        }
        return $res;
    }
}