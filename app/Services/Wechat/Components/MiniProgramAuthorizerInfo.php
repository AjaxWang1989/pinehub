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
 * @property string $signature
 * @property array $miniProgramInfo
 * @property string $authorizerAppid
 * @property string $authorizerRefreshToken
 * @property array $funcInfo
 * */
class MiniProgramAuthorizerInfo
{

    protected $authorizerInfo = [];

    protected $authorizationInfo = [];

    public function __construct(array $info)
    {
        $this->authorizerInfo = $info['authorizer_info'];
        $this->authorizationInfo = $info['authorization_info'];
    }

    /**
     * @return array
     */
    public function getMiniProgramInfo(): array
    {
        return $this->authorizerInfo['MiniProgramInfo'];
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->authorizerInfo['alias'];
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->authorizerInfo['signature'];
    }

    /**
     * @return array
     */
    public function getAuthorizationInfo(): array
    {
        return $this->authorizerInfo['authorization_info'];
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
        return $this->authorizerInfo['headImg'];
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
        return $this->authorizationInfo['funcInfo'];
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
}