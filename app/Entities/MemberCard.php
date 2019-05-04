<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\MemberCard
 *
 * @property int $id
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property string $appId 应用id
 * @property int $isGiveByFriend 是否朋友赠送
 * @property string|null $friendOpenId 好友微信open id
 * @property int|null $userId 用户id
 * @property int $bonus 会员积分
 * @property float $balance 会员卡余额
 * @property string|null $openId 微信open id
 * @property string|null $unionId 微信open id
 * @property string|null $outerStr 领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。
 * @property int $active 是否激活
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\Card $card
 * @property-read \App\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereFriendOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereIsGiveByFriend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereOuterStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereUserId($value)
 * @mixin \Eloquent
 */
class MemberCard extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'card_code',
        'app_id',
        'user_id',
        'bonus',
        'balance'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function card() : BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }

    public function app() : BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

}
