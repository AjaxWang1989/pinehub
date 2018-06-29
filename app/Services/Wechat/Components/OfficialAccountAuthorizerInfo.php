<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/28
 * Time: 下午3:39
 */

namespace App\Services\Wechat\Components;

/**
 * @property string $nickname
 * @property string $headImg
 * @property array $serviceTypeInfo
 * @property array $verifyTypeInfo
 * @property string $userName
 * @property string $principalName
 * @property string $alias
 * @property array $businessInfo
 * @property string $qrcodeUrl
 * @property array $authorizationInfo
 * @property string $authorizerAppid
 * @property string $authorizerRefreshToken
 * @property array $funcInfo
 * @property string $signature
 * */
class OfficialAccountAuthorizerInfo
{
    protected $authorizerInfo = [];

    protected $authorizationInfo = [];

    public function __construct(array $info)
    {
        $this->authorizerInfo = $info['authorizer_info'];

        $this->authorizationInfo = $info['authorization_info'];
    }

    /**
     * @return null
     */
    public function getMiniProgramInfo()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->authorizerInfo['alias'];
    }

    /**
     * @return array
     */
    public function getAuthorizationInfo(): array
    {
        return $this->authorizationInfo;
    }

    /**
     * @return array
     */
    public function getAuthorizerInfo(): array
    {
        return $this->authorizerInfo;
    }

    /**
     * @return array
     */
    public function getBusinessInfo(): array
    {
        return $this->authorizerInfo['business_info'];
    }

    /**
     * @return string
     */
    public function getHeadImg(): string
    {
        return $this->authorizerInfo['head_img'];
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->authorizerInfo['nick_name'];
    }


    /**
     * @return string
     */
    public function getPrincipalName(): string
    {
        return $this->authorizerInfo['principal_name'];
    }


    /**
     * @return string
     */
    public function getQrcodeUrl(): string
    {
        return $this->authorizerInfo['qrcode_url'];
    }

    /**
     * @return array
     */
    public function getServiceTypeInfo(): array
    {
        return $this->authorizerInfo['service_type_info'];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->authorizerInfo['user_name'];
    }

    /**
     * @return array
     */
    public function getVerifyTypeInfo(): array
    {
        return $this->authorizerInfo['verify_type_info'];
    }

    /**
     * @return array
     */
    public function getFuncInfo(): array
    {
        return $this->authorizationInfo['func_info'];
    }

    /**
     * @return string
     */
    public function getAuthorizerRefreshToken(): string
    {
        return $this->authorizationInfo['authorizer_refresh_token'];
    }

    /**
     * @return string
     */
    public function getAuthorizerAppid(): string
    {
        return $this->authorizationInfo['authorizer_appid'];
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->authorizerInfo['signature'];
    }

}