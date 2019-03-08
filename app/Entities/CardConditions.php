<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CardConditions.
 *
 * @package namespace App\Entities;
 */
class CardConditions extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id', 'paid', 'valid_obj', 'pre_payment_amount',
        'loop', 'loop_order_num', 'loop_order_amount'
    ];

    protected $casts = [
        'valid_obj' => 'array'
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}
