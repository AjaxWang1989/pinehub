<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/21
 * Time: 下午10:31
 */

namespace App\Ali\Payment\Data;


use Payment\Common\Ali\Data\Charge\ChargeBaseData;

/**
 * @property $buyer_id
 * */
class WapPaymentData extends ChargeBaseData
{
    /**
     * 业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递
     *
     * @return string
     */
    protected function getBizContent()
    {
        $content = [
            'body'          => strval($this->body),
            'subject'       => strval($this->subject),
            'out_trade_no'  => strval($this->order_no),
            'total_amount'  => strval($this->amount),
            'buyer_id'      => $this->buyer_id
        ];

        $timeExpire = $this->timeout_express;
        if (! empty($timeExpire)) {
            $express = floor(($timeExpire - strtotime($this->timestamp)) / 60);
            ($express > 0) && $content['timeout_express'] = $express . 'm';// 超时时间 统一使用分钟计算
        }

        return $content;
    }
}