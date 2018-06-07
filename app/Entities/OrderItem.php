<?php /** @noinspection ALL */

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @property string $orderCode 订单编号
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
 * @property string|null $app 程序类型：青食、自提
 * @property int|null $buyerUserId 买家ID
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereApp($value)
 */
class OrderItem extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const ORDERITEM_NUMBER_PREFIX = 'PHS';

    protected $dates = [
        'signed_at',
        'consigned_at'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'buyer_user_id', 'total_amount', 'payment_amount', 'discount_amount', 'main_image', 'origin_price', 'sell_price',
        'status', 'shop_id', 'signed_at', 'merchandise_id', 'sku_product_id', 'consigned_at', 'post_no', 'post_name', 'quality',
        'cost_price', 'order_id'
    ];

    public function buyer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_user_id', 'id');
    }

    public function shop() : BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function skuProduct() : BelongsTo
    {
        return $this->belongsTo(SKUProduct::class, 'sku_product_id', 'id');
    }
}
