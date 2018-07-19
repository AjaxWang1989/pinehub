<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/21
 * Time: 下午10:25
 */

namespace App\Ali\Payment;


use App\Ali\Payment\Data\WapPaymentData;
use Illuminate\Support\Facades\Log;
use Payment\Common\Ali\AliBaseStrategy;
use Payment\Common\PayException;

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
     * @return array
     * @throws
     */
    protected function retData(array $data)
    {
        $reqData = parent::retData($data);
        // 发起网络请求
        try {
            $data = $this->sendReq($reqData);
            Log::debug('alipayment config', $this->config->toArray());
        } catch (PayException $e) {
            throw $e;
        }

        // 检查是否报错
        if ($data['code'] !== '10000') {
            new PayException($data['sub_msg']);
        }
        return $data;
    }
}