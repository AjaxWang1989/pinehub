<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/21
 * Time: 下午10:25
 */

namespace App\Ali\Payment;


use App\Ali\Payment\Data\WapPaymentData;
use Payment\Common\Ali\AliBaseStrategy;

class WapPayment extends AliBaseStrategy
{
    // wap 支付接口名称
    protected $method = 'alipay.trade.create';

    /**
     * 获取支付对应的数据完成类
     * @return string
     * @author helei
     */
    public function getBuildDataClass()
    {
        $this->config->method = $this->method;
        // 以下两种方式任选一种
        return WapPaymentData::class;
    }

    /**
     * 返回可发起h5支付的请求
     * @param array $data
     * @return array|string
     */
    protected function retData(array $data)
    {
        $data = parent::retData($data);
        return $data;
    }
}