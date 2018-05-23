<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/22
 * Time: 下午3:39
 */

namespace App\Ali\Oauth;


use App\Ali\Oauth\Data\AuthData;
use Payment\Common\Ali\AliBaseStrategy;

class Auth extends AliBaseStrategy
{
    /**
     * @var AuthData
     * */
    protected $reqData = null;
    // wap 支付接口名称
    protected $method = 'alipay.user.info.auth';

    protected $authGateway = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';

    protected $redirect = null;

    public function __construct(array $config)
    {
        parent::__construct($config);

        if (isset($config['use_sandbox']) && $config['use_sandbox'] === true) {
            $this->authGateway = 'https://openauth.alipaydev.com/oauth2/publicAppAuthorize.htm';
        }
        $this->redirect = $config['redirect_url'];
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
        $query['app_id'] = $this->config->appId;
        $query['redirect_uri'] = $this->redirect;
        $query['scope'] = $this->reqData->scopes;
        $query['state'] = $this->reqData->state;
        // 发起网络请求
        return $this->authGateway . '?' . http_build_query($query);
    }
}