<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 9:33
 */

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/*
 * App\Entities\ShoppingCart
 *
 * @property int $id
 * @property string|null $appId 系统app id
 * @property int|null $shopId 店铺shop id
 * @property int|null $memberId 买家会员id
 * @property int|null customerId 买家customerId
 * @property int|null $merchandiseId 商品信息merchandise id
 * @property int|null $skuProductId 产品sku product id
 * @property int $quality 订单产品数量
 * @property float $sellPrice 售价
 * @property varchar $amount 总价
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property \Carbon\Carbon|null $deleteAt
 * @property-read \App\Entities\Shop|null $shop
 * @property-read \App\Entities\User|null $user
 * @property-read \App\Entities\Merchandise|null $merchandise
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity wherePosterImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShoppingCart extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $table = "shopping_cart";

    protected $fillable =[
        'app_id','shop_id','member_id','customer_id','merchandise_id','sku_product_id','quality','sell_price','amount'
    ];

    public function shop():BelongsTo
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function merchandise():BelongsTo
    {
        return $this->belongsTo(Merchandise::class,'merchandise_id','id');
    }
}