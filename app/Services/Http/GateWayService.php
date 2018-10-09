<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/8/21
 * Time: 上午9:44
 */

namespace App\Services\Http;


class GateWayService
{
    protected $domain = null;
    protected $gateways = null;
    public function __construct(string  $domain, array  $gateways)
    {
        $this->domain = $domain;
        $this->gateways = collect($gateways)->map(function ($value) use ($domain) {
            return $value;
        });
    }

    public function has($gateway) {
        if(preg_match("/{$this->domain}/", $gateway, $matches) && $gateway !== $this->domain) {
            $gateway = substr($gateway, 0, strlen($gateway) - strlen($this->domain) - 1);
        }
        return $gateway === $this->domain || $this->gateways->search($gateway);
    }

    public function getGateway(string $gateway) {
        if($this->has($gateway)) {
            return preg_match("/{$this->domain}/", $gateway, $matches) ? $gateway : $gateway.'.'.$this->domain;
        }
        return null;
    }
}
