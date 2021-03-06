<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/21
 * Time: 下午10:50
 */

namespace App\Ali\Payment;


use Payment\ChargeContext;

class AliChargeContext extends ChargeContext
{
    public function initCharge($channel, array $config)
    {
        if($channel === Config::ALI_TRADE_CREATE){
            $this->channel = new WapPayment($config);
        }else{
            parent::initCharge($channel, $config); // TODO: Change the autogenerated stub
        }
    }
}