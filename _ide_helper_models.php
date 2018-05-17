<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entities{
/**
 * App\Entities\City
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property int $provinceId 省份ID
 * @property string $code 城市编码
 * @property string $name 城市名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read integer  countiesCount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Country
 *
 * @property int $id
 * @property string $code 国家或者地区编码区号
 * @property string $name 国家或者地区名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Province[] $provinces
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read integer  citiesCount
 * @property-read integer  provincesCount
 * @property-read integer  countiesCount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Country extends \Eloquent {}
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
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
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
 * @mixin \Eloquent
 */
	class County extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Group
 *
 * @property int $id
 * @property string $code 部门编号
 * @property string $displayName 部门名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Group extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Merchandise
 *
 * @property int $id
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
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\SKUProduct[] $skuProducts
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
 * @mixin \Eloquent
 */
	class Merchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Order
 *
 * @property int $id
 * @property string $code 订单编号
 * @property int|null $buyerUserId 买家
 * @property float $totalAmount 应付款
 * @property float $paymentAmount 实际付款
 * @property float $discountAmount 优惠价格
 * @property \Carbon\Carbon|null $paidAt 支付时间
 * @property string $payType 支付方式默认微信支付
 * @property int $status 订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成
 * @property int $cancellation 取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消
 * @property \Carbon\Carbon|null $signedAt 签收时间
 * @property string $receiverCity 收货城市
 * @property string $receiverDistrict 收货人所在城市区县
 * @property string $receiverAddress 收货地址
 * @property \Carbon\Carbon|null $consignedAt 发货时间
 * @property string $postNo 物流订单号
 * @property string $postCode 收货地址邮编
 * @property string $postName 物流公司名称
 * @property int $type 订单类型：0-线下扫码 1-预定自提 2-商城订单
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\User|null $buyer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property int $postType 0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostType($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\OrderItem
 *
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int $buyerUserId 买家ID
 * @property int $orderId 订单id
 * @property string $code 订单子项编码
 * @property int $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property float $totalAmount 应付
 * @property float $discountAmount 优惠
 * @property float $paymentAmount 实付
 * @property int $status 订单状态：0-订单取消 10-已确定 20-已支付 30-已发货 40-已完成
 * @property \Carbon\Carbon|null $signedAt 签收时间
 * @property \Carbon\Carbon|null $consignedAt 发货时间
 * @property string $postNo 物流订单号
 * @property string $postName 物流公司名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\User $buyer
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Order $order
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Entities{
/**
 * Class OrderItemMerchandise.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int|null $buyerUserId 买家ID
 * @property int $orderId 订单id
 * @property int $orderItemId 子订单id
 * @property int|null $merchandiseId 产品id
 * @property int|null $skuProductId 规格产品ID
 * @property string|null $mainImage 产品主图
 * @property float $originPrice 原价
 * @property float $sellPrice 售价
 * @property float $costPrice 成本价
 * @property int $quality 订单产品数量
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereOriginPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereSkuProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItemMerchandise whereUpdatedAt($value)
 */
	class OrderItemMerchandise extends \Eloquent {}
}

namespace App\Entities{
/**
 * Class OrderPost.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int|null $shopId 店铺ID
 * @property int|null $buyerUserId 买家ID
 * @property int $orderId 订单id
 * @property int $orderItemId 子订单id
 * @property string|null $postNo 物流订单号
 * @property string|null $postCode 收货地址邮编
 * @property string|null $postName 物流公司名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPost whereId($value)
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
 * App\Entities\Province
 *
 * @property int $id
 * @property int $countryId 国家ID
 * @property string $code 省份编码
 * @property string $name 省份名称
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\County[] $counties
 * @property-read \App\Entities\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
 * @property-read integer countiesCount
 * @property-read integer  citiesCount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Province whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Province extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Role
 *
 * @property int $id
 * @property string $slug 角色标识
 * @property string $displayName 角色显示名称
 * @property int|null $groupId 部门组织id
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\Group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Shop
 *
 * @property int $id
 * @property int $userId 店铺老板用户id
 * @property int $countryId 国家id
 * @property int $provinceId 省份id
 * @property int $cityId 城市id
 * @property int $countyId 所属区县id
 * @property string|null $address 详细地址
 * @property mixed|null $position 店铺定位
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
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\County $county
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \App\Entities\Province $province
 * @property-read \App\Entities\User $shopManager
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop overlaps($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCountyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereGeoHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereProvinceId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop within($geometryColumn, $polygon)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property string|null $description 描述
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Shop whereDescription($value)
 */
	class Shop extends \Eloquent {}
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
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
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
 * @mixin \Eloquent
 */
	class ShopProduct extends \Eloquent {}
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
 * @property int $stockNum 库存
 * @property int $sellNum 已售出数量
 * @property int $status 状态：0-下架 1-上架
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Shop[] $shops
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
 * @mixin \Eloquent
 */
	class SKUProduct extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\User
 *
 * @property int $id
 * @property string $mobile 用户手机号码
 * @property string $userName 用户名称
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property string $sex 性别
 * @property string|null $avatar 头像
 * @property string|null $city 城市
 * @property int $vipLevel VIP等级
 * @property \Carbon\Carbon|null $lastLoginAt 最后登录时间
 * @property int $status 用户状态0-账户冻结 1-激活状态 2-等待授权
 * @property string $mobileCompany 手机号码所属公司
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @property string $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereMobileCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereVipLevel($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereProvince($value)
 * @property string|null $province 省份
 * @property string|null $country 国家
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 */
	class User extends \Eloquent {}
}

namespace App\Entities{
/**
 * Class WechatUser.
 *
 * @package namespace App\Entities;
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatUser whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $userId 用户ID
 * @property string $openId open id
 * @property string $sessionKey session key
 * @property string $expiresAt session 过期
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 */
	class WechatUser extends \Eloquent {}
}

