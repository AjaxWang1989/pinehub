<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:39
 */

namespace App\Ali\Oauth;


use App\Ali\Oauth\Data\AuthData;
use Illuminate\Support\Facades\Log;
use Payment\Common\Ali\AliBaseStrategy;

class Auth extends AliBaseStrategy
{
    // wap 支付接口名称
    protected $method = 'alipay.user.info.auth';

    protected $authGateway = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (isset($config['use_sandbox']) && $config['use_sandbox'] === true) {
            $this->authGateway = 'https://openauth.alipaydev.com/oauth2/publicAppAuthorize.htm';
        }
    }

    /**
     * 获取支付对应的数据完成类
     * @return string
     * @author helei
     */
    public function getBuildDataClass()
    {
        $this->config->method = $this->method;
        // 以下两种方式任选一种
        return AuthData::class;
    }

    /**
     * 返回可发起h5支付的请求
     * @param array $data
     * @return array
     * @throws
     */
    protected function retData(array $data)
    {
//        $data = parent::retData($data);
        Log::debug('ali signed data', $data);
        // 发起网络请求
        return $this->authGateway . '?' . http_build_query($data);
    }
}