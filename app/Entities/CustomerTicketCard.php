<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\CustomerTicketCard
 *
 * @property int $id
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property string $appId 应用id
 * @property int $customerId 客户id
 * @property int $status 0-不可用，1-可用，2-已使用，3-过期
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\Card $card
 * @property-read \App\Entities\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CustomerTicketCard whereUsed($value)
 * @mixin \Eloquent
 */
class CustomerTicketCard extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'card_info' => 'json'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'card_code',
        'app_id',
        'customer_id',
        'status'
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'card_id');
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
