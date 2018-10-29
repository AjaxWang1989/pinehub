<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @mixin \Eloquent
 */
class OrderItemMerchandise extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'name',
        'merchandise_id',
        'sku_product_id',
        'order_id',
        'order_item_id',
        'main_image',
        'origin_price',
        'sell_price',
        'cost_price',
        'quality',
        'member_id'
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function shop() : BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function skuProduct() : BelongsTo
    {
        return $this->belongsTo(SKUProduct::class, 'sku_product_id', 'id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function orderItem() : BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }

}
