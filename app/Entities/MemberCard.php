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
 * @property int|null $isGiveByFriend
 * @property string $appId 应用id
 * @property int $userId 用户id
 * @property string|null $openId
 * @property string|null $friendOpenId
 * @property string|null $unionId
 * @property int|null $active
 * @property string|null $outerStr
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property-read \App\Entities\App $app
 * @property-read \App\Entities\Card $card
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCard whereAppId($value)
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
 * @property int $cardId 卡券card id
 * @property string $cardCode 核销码
 * @property int|null $isGiveByFriend
 * @property string $appId 应用id
 * @property int $userId 用户id
 * @property string|null $openId
 * @property string|null $friendOpenId
 * @property string|null $unionId
 * @property string|null $outerStr
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
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
        'user_id'
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
