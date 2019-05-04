<?php

namespace App\Entities;

use App\Entities\Traits\JsonQuery;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CardConditions.
 *
 * @property array $validObj
 * @property int $cardId
 * @property int $paid
 * @property double $prePaymentAmount
 * @property int $loop
 * @property int $loopOrderNum
 * @property int $loopOrderAmount
 * @property-read \App\Entities\Card|null $card
 * @package namespace App\Entities;
 * @property int $id
 * @property string $type 条件类型
 * @property string $cardId 卡券ID
 * @property array $validObj 作用对象["merchandises" => null, "shops" => null, "customers" => ["sex" => MALE/FEMALE, "tags" => null] ]
 * @property array $show 投放/使用场景[0 （通用）1(聚合支付), 2（邻里优先）, 3（预订商场）]
 * @property float $prePaymentAmount 单笔支付满额领取
 * @property int $loopOrderNum 周期内购买多少单
 * @property int $loopOrderAmount 周期内消费总额
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions jsonSearch($key, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereLoop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereLoopOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereLoopOrderNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions wherePrePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CardConditions whereValidObj($value)
 * @mixin \Eloquent
 */
class CardConditions extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess, JsonQuery;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'card_id', 'valid_obj', 'pre_payment_amount', 'show',
        'loop', 'loop_order_num', 'loop_order_amount'
    ];

    protected $casts = [
        'valid_obj' => 'array',
        'show' => 'array'
    ];

    public function setShowAttribute($scenarios)
    {
        $newShow = [];
        foreach ($scenarios as $scenario) {
            $newShow[] = $scenario . '';
        }
        $this->attributes['show'] = json_encode($newShow);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}
