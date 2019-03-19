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
 * @property array $validObj
 * @property int $cardId
 * @property int $paid
 * @property double $prePaymentAmount
 * @property int $loop
 * @property int $loopOrderNum
 * @property int $loopOrderAmount
 * @property-read \App\Entities\Card|null $card
 * @package namespace App\Entities;
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
