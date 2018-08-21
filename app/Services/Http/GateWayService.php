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
            return $value.'.'.$domain;
        });
    }

    public function has($gateway) {
        return $this->gateways->search($gateway);
    }
}