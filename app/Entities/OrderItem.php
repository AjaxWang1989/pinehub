<?php /** @noinspection ALL */

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\OrderItem
 *
 * @property int $id
 * @property string|null $appId 系统appid
 * @property int|null $shopId 店铺ID
 * @property int|null $activityMerchandisesId 新品活动商品id
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
 * @property string|null $PaidAt 支付时间
 * @property int $status 订单状态：0-订单取消 100-等待提交支付订单 200-提交支付订单 300-支付完成 400-已发货 500-订单完成 600-支付失败
 * @property \Carbon\Carbon|null $signedAt 签收时间
 * @property \Carbon\Carbon|null $consignedAt 发货时间
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \App\Entities\Order $order
 * @property-read \App\Entities\Merchandise $merchandise
 * @property-read \App\Entities\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
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
        'app_id','shop_id','member_id','customer_id','order_id','code','merchandise_id','sku_product_id','name',
        'main_image','origin_price','sell_price','cost_price','quality','total_amount','discount_amount','payment_amount',
        'paid_at','status','signed_at','consigned_at','activity_merchandises_id'
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
}
