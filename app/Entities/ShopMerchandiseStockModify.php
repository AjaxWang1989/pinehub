<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 15:50
 */

namespace App\Entities;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ShopMerchandiseStockModify query()
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
 * @mixin \Eloquent
 */

class ShopMerchandiseStockModify extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;
    /**
     * @var array
     */
    protected $table = 'shop_merchandise_stock_modify';
    protected $fillable = [
        'shop_id','merchandise_id','product_id','primary_stock_num','modify_stock_num','reason','comment'
    ];

}