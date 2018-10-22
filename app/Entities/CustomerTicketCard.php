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
 *  * @property int $isGiveByFriend 是否朋友赠送
 * @property string|null $friendOpenId 好友微信open id
 * @property int $customerId 客户id
 * @property string|null $openId 微信open id
 * @property string|null $unionId 微信open id
 * @property string|null $outerStr 领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。
 * @property int $active 是否激活
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

    const STATUS_off = 0;
    const STATUS_ON = 1;
    const STATUS_USE = 2;
    const STATUS_EXPIRE = 3;

    const ACTIVE_ON = 1;
    const ACTIVE_OFF = 0;

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
        'is_give_by_friend',
        'friend_open_id',
        'open_id',
        'union_id',
        'outer_str',
        'active',
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
