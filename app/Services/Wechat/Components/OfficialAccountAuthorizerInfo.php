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
 * */
class OfficialAccountAuthorizerInfo
{
    protected $authorizerInfo = [];

    public function __construct(array $authorizerInfo)
    {
        $this->authorizerInfo = $authorizerInfo;
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
}