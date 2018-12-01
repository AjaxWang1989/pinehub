<?php

namespace App\Entities;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\MemberCardInfo
 *
 * @property int $id
 * @property string $code 卡卷编号
 * @property string $cardId 卡券id
 * @property string|null $wechatAppId 微信app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property string $cardType 卡券类型
 * @property array $cardInfo 卡券信息
 * @property int $issueCount 发行数量
 * @property int $userGetCount 领取数量
 * @property int $status 0-审核中 1-审核通过 2-审核未通过
 * @property int $sync -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功
 * @property \Illuminate\Support\Carbon|null $beginAt 开始日期
 * @property \Illuminate\Support\Carbon|null $endAt 结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $members
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereCardInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereIssueCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereUserGetCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MemberCardInfo whereWechatAppId($value)
 * @mixin \Eloquent
 */
class MemberCardInfo extends Card
{
    protected $table = 'cards';

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'member_cards',
            'card_id', 'user_id');
    }

    public static function boot()
    {
        MemberCardInfo::creating(function(MemberCardInfo $memberCardInfo) {
            $memberCardInfo->code = 'MC'.app('uid.generator')->getUid(MEMBER_CARD_CODE_FORMAT,
                    MEMBER_CARD_SEGMENT_MAX_LENGTH);
            return $memberCardInfo;
        });
    }
}
