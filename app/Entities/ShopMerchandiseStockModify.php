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
 * Class ShopMerchandiseStockModify
 * @package App\Entities
 * @property int $id
 * @property int $shopId 店铺id
 * @property int $merchandiseId 商品ID
 * @property int|null $productId sku单品ID
 * @property int $PrimaryStockNum 原库存数量
 * @property int $ModifyStockNum 修改后库存数量
 * @property string|null $reason 修改原因
 * @property string|null $comment 备注
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property \Carbon\Carbon|null $deleteAt
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