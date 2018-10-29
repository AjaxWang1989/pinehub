<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entities{
/**
 * App\Entities\ActivityMerchandise
 *
 * @property int $id
 * @property int $activityId 活动ID
 * @property int|null $shopId 店铺活动时显示的店铺ID
 * @property int|null $shopMerchandiseId 店铺活动时显示的店铺产品ID
 * @property int $merchandiseId 产品ID
 * @property float $sellPrice 售价
 * @property int|null $productId sku单品ID
 * @property int $stockNum 参与活动的数量:-1无限制，大于0参与活动商品数量，0售罄
 * @property int $sellNum 已售出数量
 * @property string $tags 产品标签
 * @property string $describe 产品介绍
 * @property string|null $startAt 开售时间
 * @property string|null $endAt 结业时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Merchandise[] $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereDescribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereShopMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityMerchandise whereUpdatedAt($value)
 */
	class ActivityMerchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Card
 *
 * @property int $id
 * @property string $cardId 卡券id
 * @property string|null $wechatAppId 微信app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property string $cardType 卡券类型
 * @property array $cardInfo 卡券信息
 * @property int $status 0-审核中 1-审核通过 2-审核未通过
 * @property int $sync -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功
 * @property \Illuminate\Support\Carbon|null $beginAt 开始日期
 * @property \Illuminate\Support\Carbon|null $endAt 结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $records
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Card whereWechatAppId($value)
 */
	class Card extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\WechatMenu
 *
 * @property int $id
 * @property string $appId 微信app id
 * @property string|null $name 菜单名称
 * @property int $isPublic 菜单是否发布
 * @property array $menus menus
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereMenus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMenu whereUpdatedAt($value)
 */
	class WechatMenu extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ScoreRule
 *
 * @property int $id
 * @property string|null $name 规则名称
 * @property string $appId 系统应用appid
 * @property int $score 增加的积分数
 * @property int $totalScore 累计积分数
 * @property int $type 类型 0-通用规则 type & 8 == true 特殊规则
 * @property \Illuminate\Support\Carbon $expiresAt 过去日期，null表示永远有效
 * @property int $noticeUser 是否给用户发送积分通知
 * @property array $rule 积分自定义规则：{"focus": true, "order_count": 100, "order_amount"" 1000, "merchandise":null}
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereNoticeUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreRule whereUpdatedAt($value)
 */
	class ScoreRule extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Category
 *
 * @property int $id
 * @property string|null $appId 系统app id
 * @property string $icon 图标
 * @property string $name 分类名称
 * @property int $parentId 分类父级
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Merchandise[] $merchandises
 * @property-read \App\Entities\Category $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\UserTicket
 *
 * @property int $id
 * @property string $cardId 优惠券id
 * @property string $cardCode 优惠券编码
 * @property int $userId 会员id
 * @property int $status 0-不可用，1-可用，2-已使用，3-过期
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Card $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\UserTicket whereUserId($value)
 */
	class UserTicket extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Merchandise
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $code 产品编号
 * @property string $name 产品名称
 * @property string $mainImage 主图
 * @property array $images 轮播图数组
 * @property string $preview 简介
 * @property string $detail 详情
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价格
 * @property float $factoryPrice 工厂价格
 * @property int $capacity 产能（工厂生产能力）
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\SKUProduct[] $skuProducts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereFactoryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Merchandise whereUpdatedAt($value)
 */
	class Merchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\WechatConfig
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string $appSecret 微信公众号secret
 * @property string $appName 微信公众号或者小程序名称
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICIAL_ACCOUNT 公众平台， 
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string $mode 公众号模式
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property string|null $nickname 公众号或者小程序昵称
 * @property string|null $headImg 微信公众号或者小程序头像
 * @property string|null $userName 授权方公众号的原始ID
 * @property string|null $alias 授权方公众号所设置的微信号，可能为空
 * @property string|null $principalName 公众号的主体名称
 * @property string|null $qrcodeUrl 二维码图片的URL，开发者最好自行也进行保存
 * @property string|null $authCode
 * @property \Illuminate\Support\Carbon|null $authCodeExpiresIn
 * @property string|null $authInfoType
 * @property string|null $componentAccessToken 第三方平台access_token
 * @property \Illuminate\Support\Carbon|null $componentAccessTokenExpiresIn 有效期，为2小时
 * @property string|null $authorizerRefreshToken 授权刷新令牌
 * @property string|null $authorizerAccessToken 授权令牌
 * @property \Illuminate\Support\Carbon|null $authorizerAccessTokenExpiresIn 授权令牌,有效期，为2小时
 * @property array|null $serviceTypeInfo 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
 * @property array|null $verifyTypeInfo 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，
 *             3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
 * @property array|null $businessInfo 用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门
 *             店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
 * @property array|null $funcInfo 公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限 
 *             2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 
 *             12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
 *             帐号类型和认证情况，来判断公众号的接口权限
 * @property array|null $miniProgramInfo 可根据这个字段判断是否为小程序类型授权
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\WechatMenu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAesKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthCodeExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereAuthorizerRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereBusinessInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereComponentAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereComponentAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereFuncInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereHeadImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereMiniProgramInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig wherePrincipalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereServiceTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereVerifyTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatConfig whereWechatBindApp($value)
 */
	class WechatConfig extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\App
 *
 * @property string $id app id
 * @property int|null $ownerUserId 应用拥有者
 * @property string $secret 应用secret
 * @property string $name 应用名称
 * @property string $logo 应用logo
 * @property string $contactName 联系人名称
 * @property string $contactPhoneNum 联系电话
 * @property string|null $wechatAppId 微信公众号appid
 * @property string|null $miniAppId 小程序appid
 * @property string|null $openAppId api创建open platform appid
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\MiniProgram $miniProgram
 * @property-read \App\Entities\OfficialAccount $officialAccount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereContactPhoneNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereMiniAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereOpenAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereOwnerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\App whereWechatAppId($value)
 */
	class App extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Seller
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @property-read \App\Entities\User $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Seller whereVipLevel($value)
 */
	class Seller extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Group
 *
 * @property int $id
 * @property string $code 部门编号
 * @property string $displayName 部门名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MiniProgram
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string $appSecret 微信公众号secret
 * @property string $appName 微信公众号或者小程序名称
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICIAL_ACCOUNT 公众平台， 
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string $mode 公众号模式
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property string|null $nickname 公众号或者小程序昵称
 * @property string|null $headImg 微信公众号或者小程序头像
 * @property string|null $userName 授权方公众号的原始ID
 * @property string|null $alias 授权方公众号所设置的微信号，可能为空
 * @property string|null $principalName 公众号的主体名称
 * @property string|null $qrcodeUrl 二维码图片的URL，开发者最好自行也进行保存
 * @property string|null $authCode
 * @property \Illuminate\Support\Carbon|null $authCodeExpiresIn
 * @property string|null $authInfoType
 * @property string|null $componentAccessToken 第三方平台access_token
 * @property \Illuminate\Support\Carbon|null $componentAccessTokenExpiresIn 有效期，为2小时
 * @property string|null $authorizerRefreshToken 授权刷新令牌
 * @property string|null $authorizerAccessToken 授权令牌
 * @property \Illuminate\Support\Carbon|null $authorizerAccessTokenExpiresIn 授权令牌,有效期，为2小时
 * @property array|null $serviceTypeInfo 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
 * @property array|null $verifyTypeInfo 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，
 *             3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
 * @property array|null $businessInfo 用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门
 *             店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
 * @property array|null $funcInfo 公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限 
 *             2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 
 *             12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
 *             帐号类型和认证情况，来判断公众号的接口权限
 * @property array|null $miniProgramInfo 可根据这个字段判断是否为小程序类型授权
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\WechatMenu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAesKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthCodeExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthorizerAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthorizerAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereAuthorizerRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereBusinessInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereComponentAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereComponentAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereFuncInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereHeadImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereMiniProgramInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram wherePrincipalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereServiceTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereVerifyTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgram whereWechatBindApp($value)
 */
	class MiniProgram extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Order
 *
 * @property int $id
 * @property string $code 订单编号
 * @property string|null $openId 微信open id或支付宝user ID
 * @property string|null $wechatAppId 维系app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property int|null $shopId 店铺id
 * @property int|null $activityId 新品活动id
 * @property int|null $activityMerchandisesId 新品预定商品id
 * @property int|null $memberId 买家会员id
 * @property string $cardId 优惠券id
 * @property int|null $customerId 买家
 * @property int|null $merchandiseNum 此订单商品数量总数
 * @property float $totalAmount 应付款
 * @property float $paymentAmount 实际付款
 * @property float $discountAmount 优惠价格
 * @property \Illuminate\Support\Carbon|null $paidAt 支付时间
 * @property int $payType 支付方式默认微信支付:0-未知，1-支付宝，2-微信支付
 * @property int $status 订单状态：0-订单取消 100-等待提交支付订单 200-提交支付订单 300-支付完成 400-已发货 500-订单完成 600-支付失败
 * @property int $cancellation 取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消
 * @property \Illuminate\Support\Carbon|null $signedAt 签收时间
 * @property string|null $receiverCity 收货城市
 * @property string|null $receiverDistrict 收货人所在城市区县
 * @property string|null $receiverName 收货姓名
 * @property string|null $receiverAddress 收货地址
 * @property string|null $receiverMobile 收货人电话
 * @property string|null $sendStartTime 配送开始时间
 * @property string|null $sendEndTime 配送结束时间
 * @property string|null $comment 备注
 * @property \Illuminate\Support\Carbon|null $consignedAt 发货时间
 * @property int $type 订单类型：0-线下扫码 1-预定自提 2-商城订单 3-今日下单自提 4-今日下单送到手  5-活动商品订单
 * @property int $postType 0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运
 * @property int $scoreSettle 积分是否已经结算
 * @property string|null $postNo 快递编号
 * @property string|null $postCode 邮编
 * @property string|null $postName 快递公司名称
 * @property string|null $transactionId 支付交易流水
 * @property string|null $ip 支付终端ip地址
 * @property string|null $tradeStatus 交易状态:TRADE_WAIT 等待交易 TRADE_FAILED 交易失败 TRADE_SUCCESS 交易成功 
 *                 TRADE_FINISHED 交易结束禁止退款操作 TRADE_CANCEL 交易关闭禁止继续支付
 * @property int|null $years 年
 * @property int|null $month 月
 * @property int|null $week 星期
 * @property int|null $hour 小时
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ActivityMerchandise[] $activityMerchandises
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\Card $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereActivityMerchandisesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereMerchandiseNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereScoreSettle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereSendEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereSendStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTradeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereWechatAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereYears($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ShopManager
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopManager whereVipLevel($value)
 */
	class ShopManager extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Country
 *
 * @property int $id
 * @property string $code 国家或者地区编码区号
 * @property string $name 国家或者地区名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Province[] $provinces
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\City
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property string $code 城市编码
 * @property string $name 城市名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereUpdatedAt($value)
 */
	class City extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MiniProgramTemplate
 *
 * @property int $templateId 模版id
 * @property string $userVersion 模版版本号
 * @property string $userDesc 模版描述
 * @property string $createTime 模版创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereUserDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramTemplate whereUserVersion($value)
 */
	class MiniProgramTemplate extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\WechatMaterial
 *
 * @property int $id
 * @property string $title 素材名称
 * @property string $introduction 素材介绍
 * @property int $isTmp 是否临时素材
 * @property string $mediaId 素材id
 * @property string $url 图片url
 * @property string $type 图片（image）: 2M，支持bmp/png/jpeg/jpg/gif格式;
 *             语音（voice）：2M，播放长度不超过60s，mp3/wma/wav/amr格式;视频（video）：10MB，支持MP4格式;缩略图（thumb）：64KB，支持JPG格式;图文（news）
 * @property array $articles 图文
 * @property \Illuminate\Support\Carbon $expiresAt 临时素材过期时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereArticles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereIsTmp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereUrl($value)
 */
	class WechatMaterial extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\StorePurchaseOrders
 *
 * @property int $id
 * @property string $code 订单编号
 * @property string|null $openId 微信open id或支付宝user ID
 * @property string|null $wechatAppId 维系app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property int|null $shopId 店铺id
 * @property int|null $merchandiseNum 此订单商品数量总数
 * @property float $totalAmount 应付款
 * @property float $paymentAmount 实际付款
 * @property float $discountAmount 优惠价格
 * @property \Illuminate\Support\Carbon|null $paidAt 支付时间
 * @property int $payType 支付方式默认微信支付:0-未知，1-支付宝，2-微信支付
 * @property int $status 订单状态：1-待发货 2-配送中 3-已完成 4-申请中 5-退货中 6-已拒绝
 * @property int $cancellation 取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消
 * @property \Illuminate\Support\Carbon|null $signedAt 签收时间
 * @property string|null $receiverCity 收货城市
 * @property string|null $receiverDistrict 收货人所在城市区县
 * @property string|null $receiverName 收货姓名
 * @property string|null $receiverAddress 收货地址
 * @property string|null $receiverMobile 收货人电话
 * @property string|null $sendTime 配送时间
 * @property string|null $comment 备注
 * @property \Illuminate\Support\Carbon|null $consignedAt 发货时间
 * @property int $type 订单类型：1-进货订单 2-退货订单
 * @property int $postType 0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运
 * @property int $scoreSettle 积分是否已经结算
 * @property string|null $postNo 快递编号
 * @property string|null $postCode 邮编
 * @property string|null $postName 快递公司名称
 * @property string|null $transactionId 支付交易流水
 * @property string|null $ip 支付终端ip地址
 * @property string|null $tradeStatus 交易状态:TRADE_WAIT 等待交易 TRADE_FAILED 交易失败 TRADE_SUCCESS 交易成功 
 *                 TRADE_FINISHED 交易结束禁止退款操作 TRADE_CANCEL 交易关闭禁止继续支付
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderPurchaseItems[] $orderItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereMerchandiseNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereReceiverCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereReceiverDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereReceiverMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereScoreSettle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereSendTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereTradeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\StorePurchaseOrders whereWechatAppId($value)
 */
	class StorePurchaseOrders extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\File
 *
 * @property int $id
 * @property string $endpoint 云存储节点url，本地存储root
 * @property string|null $bucket 云存储bucket或者本地存储路径
 * @property string $driver 文件存储驱动
 * @property string $path 文件路径
 * @property string|null $extension 文件拓展名
 * @property string|null $mimeType 文件类型
 * @property string|null $name 文件名
 * @property string|null $src 文件url路径
 * @property int $encrypt 是否加密
 * @property string|null $encryptKey 密钥
 * @property string|null $encryptMethod 加密算法
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereBucket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncryptKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncryptMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereUpdatedAt($value)
 */
	class File extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Ticket
 *
 * @property int $id
 * @property string $cardId 卡券id
 * @property string|null $wechatAppId 微信app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property string $cardType 卡券类型
 * @property array $cardInfo 卡券信息
 * @property int $status 0-审核中 1-审核通过 2-审核未通过
 * @property int $sync -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功
 * @property \Illuminate\Support\Carbon|null $beginAt 开始日期
 * @property \Illuminate\Support\Carbon|null $endAt 结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $records
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereCardInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Ticket whereWechatAppId($value)
 */
	class Ticket extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MiniProgramPage
 *
 * @property int $id
 * @property int $miniProgramTemplateId 小程序模版id
 * @property string $page 小程序页面路径
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereMiniProgramTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramPage whereUpdatedAt($value)
 */
	class MiniProgramPage extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Province
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property string $code 省份编码
 * @property string $name 省份名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereUpdatedAt($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\County
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property int $cityId 城市ID
 * @property string $code 区县编码
 * @property string $name 区县名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\County whereUpdatedAt($value)
 */
	class County extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OrderItem
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property int|null $shopId 店铺ID
 * @property int|null $activityMerchandisesId 新品预定商品id
 * @property int|null $memberId 买家会员id
 * @property int|null $customerId 买家ID
 * @property int $orderId 订单id
 * @property string $code 订单子项编码
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $name 产品名称
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property float $totalAmount 应付
 * @property float $discountAmount 优惠
 * @property float $paymentAmount 实付
 * @property string|null $paidAt 支付时间
 * @property int $status 订单状态：0-订单取消 100-等待提交支付订单 200-提交支付订单 300-支付完成 400-已发货 500-订单完成 600-支付失败
 * @property \Illuminate\Support\Carbon|null $signedAt 签收时间
 * @property \Illuminate\Support\Carbon|null $consignedAt 发货时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \App\Entities\Merchandise|null $merchandise
 * @property-read \App\Entities\Order $order
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereActivityMerchandisesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereUpdatedAt($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\User
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereVipLevel($value)
 */
	class User extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Role
 *
 * @property int $id
 * @property string $slug 角色标识
 * @property string $displayName 角色显示名称
 * @property int|null $groupId 部门组织id
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Member
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Member whereVipLevel($value)
 */
	class Member extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Shop
 *
 * @property int $id
 * @property string|null $code 餐车编号
 * @property string|null $name 店铺名称
 * @property int $userId 店铺老板用户id
 * @property string $countryId 国家id
 * @property int $provinceId 省份id
 * @property int $cityId 城市id
 * @property int $countyId 所属区县id
 * @property string|null $address 详细地址
 * @property mixed $position 店铺定位
 * @property string|null $description 店铺描述
 * @property string|null $geoHash 位置hash编码
 * @property float $totalAmount 店铺总计营业额
 * @property float $todayAmount 今日营业额
 * @property float $totalOffLineAmount 店铺预定总计营业额
 * @property float $todayOffLineAmount 今日线下营业额
 * @property float $totalOrderingAmount 店铺总计营业额
 * @property float $todayOrderingAmount 今日预定营业额
 * @property int $todayOrderingNum 今日预定订单数量
 * @property int $totalOrderingNum 店铺自提系统一共预定单数
 * @property int $todayOrderWriteOffAmount 今日核销订单营业额
 * @property int $totalOrderWriteOffAmount 店铺自提系统一共核营业额
 * @property int $todayOrderWriteOffNum 今日核销订单数量
 * @property int $totalOrderWriteOffNum 店铺自提系统一共核销单数
 * @property int $status 状态：0-等待授权 1-营业中 2-休业 3-封锁店铺
 * @property string|null $appId 系统app id
 * @property string|null $wechatAppId 微信app ID
 * @property string|null $aliAppId 支付宝app ID
 * @property string|null $mtAppId 美团app id
 * @property string|null $wechatParamsQrcodeUrl 微信参数二维码url
 * @property string|null $startAt 开售时间
 * @property string|null $endAt 结业时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\County $county
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\Province $province
 * @property-read \App\Entities\User $shopManager
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ShopMerchandise[] $shopMerchandises
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop comparison($geometryColumn, $geometry, $relationship)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop contains($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop crosses($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop disjoint($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distance($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceSphereValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop distanceValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop doesTouch($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop equals($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop intersects($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop near($lng, $lat, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop overlaps($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereGeoHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereMtAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOffLineAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderWriteOffAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderWriteOffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTodayOrderingNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOffLineAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderWriteOffAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderWriteOffNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereTotalOrderingNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereWechatAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereWechatParamsQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop within($geometryColumn, $polygon)
 */
	class Shop extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OrderItemMerchandise
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property int|null $shopId 店铺ID
 * @property int|null $memberId 买家会员id
 * @property int|null $customerId 买家ID
 * @property int $orderId 订单id
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $name 产品名称
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property float $totalAmount 应付
 * @property float $discountAmount 优惠
 * @property float $paymentAmount 实付
 * @property string|null $paidAt 支付时间
 * @property int $status 订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成
 * @property string|null $signedAt 签收时间
 * @property string|null $consignedAt 发货时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \App\Entities\Merchandise|null $merchandise
 * @property-read \App\Entities\Order $order
 * @property-read \App\Entities\OrderItem $orderItem
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereUpdatedAt($value)
 */
	class OrderItemMerchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ShoppingCart
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property int|null $shopId 店铺ID
 * @property int|null $activityMerchandisesId 新品预定商品id
 * @property int|null $memberId 买家会员id
 * @property int|null $customerId 买家id
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property int $quality 订单产品数量
 * @property float $sellPrice 售价
 * @property float $amount 总价
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \App\Entities\Merchandise|null $merchandise
 * @property-read \App\Entities\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereActivityMerchandisesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShoppingCart whereUpdatedAt($value)
 */
	class ShoppingCart extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OrderPurchaseItems
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property int|null $shopId 店铺ID
 * @property int $orderId 订单id
 * @property string $code 订单子项编码
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $name 产品名称
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property float $totalAmount 应付
 * @property float $discountAmount 优惠
 * @property float $paymentAmount 实付
 * @property string|null $paidAt 支付时间
 * @property int $status 订单状态：1-待发货 2-配送中 3-已完成 4-申请中 5-退货中 6-已拒绝
 * @property \Illuminate\Support\Carbon|null $signedAt 签收时间
 * @property \Illuminate\Support\Carbon|null $consignedAt 发货时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\StorePurchaseOrders $PurchaseOrder
 * @property-read \App\Entities\Merchandise|null $merchandise
 * @property-read \App\Entities\OrderItemMerchandise $orderMerchandise
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems whereUpdatedAt($value)
 */
	class OrderPurchaseItems extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\FeedBackMessage
 *
 * @property int $id
 * @property int|null $customerId 用户id
 * @property string|null $openId 微信open id或支付宝user ID
 * @property string|null $appId 系统appid
 * @property string|null $comment 反馈内容
 * @property string|null $mobile 电话
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereUpdatedAt($value)
 */
	class FeedBackMessage extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Customer
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property string|null $mobile 手机号码
 * @property int|null $memberId 会员id
 * @property string|null $platformAppId 微信公众平台、小程序、开放app id
 * @property string $type WECHAT_OFFICE_ACCOUNT 公众平台，
 *             WECHAT_OPEN_PLATFORM 微信开放平台 WECHAT_MINI_PROGRAM 微信小程序 ALIPAY_OPEN_PLATFORM  支付宝开发平台 SELF 平台客户
 * @property string|null $unionId union id
 * @property string $platformOpenId 三方平台用户唯一标志
 * @property string|null $sessionKey session key
 * @property \Illuminate\Support\Carbon $sessionKeyExpiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property array|null $privilege 微信特权信息
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property int $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道:0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $ticketRecords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePlatformAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePlatformOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSessionKeyExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Customer whereUserType($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\SKUProduct
 *
 * @property int $id
 * @property int $merchandiseId 产品id
 * @property string $code 规格产品编码
 * @property array $images 图片数组
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价格
 * @property float $factoryPrice 工厂价格
 * @property int $capacity 产能（工厂生产能力）
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereFactoryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SKUProduct whereUpdatedAt($value)
 */
	class SKUProduct extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MerchandiseCategory
 *
 * @property int $id
 * @property int $categoryId 分类id
 * @property int $merchandiseId 产品id
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Category $category
 * @property-read \App\Entities\Merchandise $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchandiseCategory whereUpdatedAt($value)
 */
	class MerchandiseCategory extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MiniProgramDraft
 *
 * @property int $draftId 草稿id
 * @property string $userVersion 模版版本号
 * @property string $userDesc 模版描述
 * @property string $createTime 草稿创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereDraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereUserDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MiniProgramDraft whereUserVersion($value)
 */
	class MiniProgramDraft extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\WechatAutoReplyMessage
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string|null $name 规则名称
 * @property int $focusReply 关注回复
 * @property string $type 类型
 * @property array|null $prefectMatchKeywords 全匹配关键字数组
 * @property array|null $semiMatchKeywords 半匹配关键字数组
 * @property string $content 回复消息内容
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereFocusReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage wherePrefectMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereSemiMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereUpdatedAt($value)
 */
	class WechatAutoReplyMessage extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MemberCard
 *
 * @property int $id
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property string $appId 应用id
 * @property int $isGiveByFriend 是否朋友赠送
 * @property string|null $friendOpenId 好友微信open id
 * @property int|null $userId 用户id
 * @property string|null $openId 微信open id
 * @property string|null $unionId 微信open id
 * @property string|null $outerStr 领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。
 * @property int $active 是否激活
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\Card $card
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereFriendOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereIsGiveByFriend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereOuterStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUserId($value)
 */
	class MemberCard extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ShopProduct
 *
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int|null $skuProductId sku单品ID
 * @property int $stockNum 库存
 * @property int $sellNum 销量
 * @property int $status 1-上架 0-下架
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopProduct whereUpdatedAt($value)
 */
	class ShopProduct extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\AliUser
 *
 * @property int $id
 * @property int|null $userId 用户id
 * @property string $appId 系统appid
 * @property string $openId 支付宝user_id
 * @property string|null $avatar 头像
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property string $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property string $gender 【注意】只有is_certified为T的时候才有意义，否则不保证准确性.
 *              性别（F：女性；M：男性）。
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserType($value)
 */
	class AliUser extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Activity
 *
 * @property int $id
 * @property string $appId 项目应用ID
 * @property string $type 活动类型
 * @property int|null $shopId 店铺id
 * @property string $title 活动名称
 * @property string $posterImg 海报图片
 * @property string $description 详情
 * @property int $status 0 未开始 1 进行中 2 已结束
 * @property string|null $startAt 活动开始时间
 * @property string|null $endAt 活动结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\PaymentActivity[] $paymentActivities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity wherePosterImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUpdatedAt($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\PaymentActivity
 *
 * @property int $id
 * @property int $activityId 活动ID
 * @property string $type 支付活动方式：满减送 PAY_FULL/支付礼包 PAY_GIFT
 * @property int|null $ticketId 优惠券id
 * @property float $discount 折扣
 * @property float $cost 抵用金额
 * @property float $leastAmount 最低消费
 * @property int $score 积分
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Activity $activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereLeastAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\PaymentActivity whereUpdatedAt($value)
 */
	class PaymentActivity extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\CustomerTicketCard
 *
 * @property int $id
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property string $appId 应用id
 * @property int $isGiveByFriend 是否朋友赠送
 * @property string|null $friendOpenId 好友微信open id
 * @property int $customerId 客户id
 * @property string|null $openId 微信open id
 * @property string|null $unionId 微信open id
 * @property string|null $outerStr 领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。
 * @property int $active 是否激活
 * @property int $status 0-不可用，1-可用，2-已使用，3-过期
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\Card $card
 * @property-read \App\Entities\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereFriendOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereIsGiveByFriend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereOuterStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUpdatedAt($value)
 */
	class CustomerTicketCard extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ScoreSettleCash
 *
 * @property int $id
 * @property int|null $scoreRuleId 积分规则id
 * @property int $score 积分数
 * @property int $type 规则类型：0 - 通用规则, type & 8 == true 特殊规则
 * @property string $scoreRuleName 积分规则名称
 * @property array $content 积分项目
 * @property int $userId 被积分用户id
 * @property int $settled
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Customer $scoreUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScoreRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereScoreRuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereSettled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ScoreSettleCash whereUserId($value)
 */
	class ScoreSettleCash extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\MpUser
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property string|null $mobile 手机号码
 * @property int|null $memberId 会员id
 * @property string|null $platformAppId 微信公众平台、小程序、开放app id
 * @property string $type WECHAT_OFFICE_ACCOUNT 公众平台，
 *             WECHAT_OPEN_PLATFORM 微信开放平台 WECHAT_MINI_PROGRAM 微信小程序 ALIPAY_OPEN_PLATFORM  支付宝开发平台 SELF 平台客户
 * @property string|null $unionId union id
 * @property string $platformOpenId 三方平台用户唯一标志
 * @property string|null $sessionKey session key
 * @property \Illuminate\Support\Carbon $sessionKeyExpiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property array|null $privilege 微信特权信息
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property int $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道:0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $ticketRecords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser wherePlatformAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser wherePlatformOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereSessionKeyExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MpUser whereUserType($value)
 */
	class MpUser extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ShopMerchandise
 *
 * @property int $id
 * @property int $shopId 店铺id
 * @property float $sellPrice 售价
 * @property int $merchandiseId 商品ID
 * @property int $categoryId 分类ID
 * @property int|null $productId sku单品ID
 * @property int $stockNum 库存数量
 * @property int $sellNum 销售数量
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\Category $category
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandise whereUpdatedAt($value)
 */
	class ShopMerchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\AppUser
 *
 * @property int $id
 * @property string $appId 系统应用id
 * @property int|null $userId 用户id
 * @property int $status 状态：0-冻结账号，1-激活 2-待激活
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\WechatUser $miniProgramUser
 * @property-read \App\Entities\WechatUser $officialAccountUser
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AppUser whereUserId($value)
 */
	class AppUser extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OfficialAccount
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string $appSecret 微信公众号secret
 * @property string $appName 微信公众号或者小程序名称
 * @property string|null $token 微信token
 * @property string|null $aesKey 微信EncodingAESKey
 * @property string $type OFFICIAL_ACCOUNT 公众平台， 
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string $mode 公众号模式
 * @property string|null $wechatBindApp 微信公众号绑定的应用程序或者小程序绑定的应用
 * @property string|null $nickname 公众号或者小程序昵称
 * @property string|null $headImg 微信公众号或者小程序头像
 * @property string|null $userName 授权方公众号的原始ID
 * @property string|null $alias 授权方公众号所设置的微信号，可能为空
 * @property string|null $principalName 公众号的主体名称
 * @property string|null $qrcodeUrl 二维码图片的URL，开发者最好自行也进行保存
 * @property string|null $authCode
 * @property \Illuminate\Support\Carbon|null $authCodeExpiresIn
 * @property string|null $authInfoType
 * @property string|null $componentAccessToken 第三方平台access_token
 * @property \Illuminate\Support\Carbon|null $componentAccessTokenExpiresIn 有效期，为2小时
 * @property string|null $authorizerRefreshToken 授权刷新令牌
 * @property string|null $authorizerAccessToken 授权令牌
 * @property \Illuminate\Support\Carbon|null $authorizerAccessTokenExpiresIn 授权令牌,有效期，为2小时
 * @property array|null $serviceTypeInfo 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
 * @property array|null $verifyTypeInfo 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，
 *             3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
 * @property array|null $businessInfo 用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门
 *             店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
 * @property array|null $funcInfo 公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限 
 *             2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 
 *             12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的
 *             帐号类型和认证情况，来判断公众号的接口权限
 * @property array|null $miniProgramInfo 可根据这个字段判断是否为小程序类型授权
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\WechatMenu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAesKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthCodeExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthorizerAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthorizerAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereAuthorizerRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereBusinessInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereComponentAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereComponentAccessTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereFuncInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereHeadImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereMiniProgramInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount wherePrincipalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereQrcodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereServiceTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereVerifyTypeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OfficialAccount whereWechatBindApp($value)
 */
	class OfficialAccount extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Administrator
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $realName 真实姓名
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property float $balance 用户余额
 * @property int $canUseScore 用户可用积分
 * @property int $score 用户积分
 * @property int $totalScore 用户总积分
 * @property int $vipLevel VIP等级
 * @property \Illuminate\Support\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property int $orderCount 订单数
 * @property int $channel 渠道来源 0-未知 1-微信 2-支付宝
 * @property int $registerChannel 注册渠道 0-未知 1-微信公众号 2-微信小程序 3-h5页面 4-支付宝小程序 5- APP
 * @property array $tags 标签
 * @property string $mobileCompany 手机号码所属公司
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\App[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Customer[] $customers
 * @property-read \App\Entities\MemberCard $memberCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCanUseScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Administrator whereVipLevel($value)
 */
	class Administrator extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OrderPost
 *
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int|null $memberId 买家会员id
 * @property int|null $customerId 买家ID
 * @property int $orderId 订单id
 * @property int $orderItemId 子订单id
 * @property string|null $postNo 物流订单号
 * @property string|null $postCode 收货地址邮编
 * @property string|null $postName 物流公司名称
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereUpdatedAt($value)
 */
	class OrderPost extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\ShopMerchandiseStockModify
 *
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int|null $productId sku单品ID
 * @property int $primaryStockNum 原库存数量
 * @property int $modifyStockNum 修改后库存数量
 * @property string|null $reason 修改原因
 * @property string|null $comment 备注
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereModifyStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify wherePrimaryStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify whereUpdatedAt($value)
 */
	class ShopMerchandiseStockModify extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\WechatUser
 *
 * @property int $id
 * @property string|null $appId 系统应用appid
 * @property int|null $userId 用户手机
 * @property string|null $wechatAppId 微信公众平台、小程序、开放app id
 * @property string $type OFFICE_ACCOUNT 公众平台， 
 *             OPEN_PLATFORM 开放平台 MINI_PROGRAM 小程序
 * @property string|null $unionId union id
 * @property string $openId open id
 * @property string $sessionKey session key
 * @property \Illuminate\Support\Carbon $expiresAt session 过期
 * @property string|null $avatar 头像
 * @property string|null $country 国家
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property string $sex 性别
 * @property mixed|null $privilege 微信特权信息
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property \Illuminate\Support\Carbon|null $deletedAt
 * @property-read \App\Entities\App|null $app
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereWechatAppId($value)
 */
	class WechatUser extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\TakeOutCar
 *
 */
	class TakeOutCar extends \Eloquent {}
}

