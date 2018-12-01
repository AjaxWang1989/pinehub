<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:10
 */

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\SKUProduct|null $skuProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrderPurchaseItems query()
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
 * @mixin \Eloquent
 */


class OrderPurchaseItems extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const CANCEL = 1;
    const WAIT = 2;
    const MAKE_SURE = 3;
    const PAID = 4;
    const SEND = 5;
    const COMPLETED = 6;

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
        'app_id','shop_id','order_id','code','merchandise_id','sku_product_id','name',
        'main_image','origin_price','sell_price','cost_price','quality','total_amount','discount_amount','payment_amount',
        'paid_at','status','signed_at','consigned_at'
    ];

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

    public function PurchaseOrder() : BelongsTo
    {
        return $this->belongsTo(StorePurchaseOrders::class, 'order_id', 'id');
    }
}