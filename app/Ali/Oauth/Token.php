<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:48
 */

namespace App\Ali\Oauth;


use App\Ali\Oauth\Data\TokenData;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Payment\Common\Ali\AliBaseStrategy;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;
use Payment\Utils\Rsa2Encrypt;
use Payment\Utils\RsaEncrypt;

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

    /**
     * 支付宝业务发送网络请求，并验证签名
     * @param array $data
     * @param string $method 网络请求的方法， get post 等
     * @return mixed
     * @throws PayException
     */
    protected function sendReq(array $data, $method = 'GET')
    {
        $client = new Client([
            'base_uri' => $this->config->getewayUrl,
            'timeout' => '10.0'
        ]);
        $method = strtoupper($method);
        $options = [];
        if ($method === 'GET') {
            $options = [
                'query' => $data,
                'http_errors' => false
            ];
        } elseif ($method === 'POST') {
            $options = [
                'form_params' => $data,
                'http_errors' => false
            ];
        }
        // 发起网络请求
        $response = $client->request($method, '', $options);

        if ($response->getStatusCode() != '200') {
            throw new PayException('网络发生错误，请稍后再试curl返回码：' . $response->getReasonPhrase());
        }

        $body = $response->getBody()->getContents();
        try {
            $body = \GuzzleHttp\json_decode($body, true);
        } catch (\InvalidArgumentException $e) {
            throw new PayException('返回数据 json 解析失败');
        }
        Log::debug('----------- ali token -----------', $body);
        $responseKey = str_ireplace('.', '_', $this->config->method) . '_response';
        if (! isset($body[$responseKey])) {
            throw new PayException('支付宝系统故障或非法请求');
        }

        // 验证签名，检查支付宝返回的数据
        $flag = $this->verifySign($body[$responseKey], $body['sign']);
        if (! $flag) {
            throw new PayException('支付宝返回数据被篡改。请检查网络是否安全！');
        }

        // 这里可能带来不兼容问题。原先会检查code ，不正确时会抛出异常，而不是直接返回
        return $body[$responseKey];
    }

    /**
     * 检查支付宝数据 签名是否被篡改
     * @param array $data
     * @param string $sign  支付宝返回的签名结果
     * @return bool
     * @author helei
     */
    protected function verifySign(array $data, $sign)
    {
        $data = ArrayUtil::arraySort($data);
        $preStr = \GuzzleHttp\json_encode($data, JSON_UNESCAPED_UNICODE);// 主要是为了解决中文问题
        Log::debug('--------------- config -------------', [$this->config->rsaAliPubKey]);
        if ($this->config->signType === 'RSA') {// 使用RSA
            $rsa = new RsaEncrypt($this->config->rsaAliPubKey);

            return $rsa->rsaVerify($preStr, $sign);
        } elseif ($this->config->signType === 'RSA2') {// 使用rsa2方式
            $rsa = new Rsa2Encrypt($this->config->rsaAliPubKey);

            return $rsa->rsaVerify($preStr, $sign);
        } else {
            return false;
        }
    }
}