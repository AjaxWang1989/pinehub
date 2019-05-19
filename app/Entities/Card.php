<?php

namespace App\Entities;

use App\Entities\Traits\JsonQuery;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Card
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
 * @property string $platform
 * @property int $status
 * @property int $syncStatus 0-审核中 1-审核通过 2-审核未通过
 * @property int $sync -1 不需要同步 0 - 同步失败 1-同步中 2-同步成功
 * @property \Illuminate\Support\Carbon|null $beginAt 开始日期
 * @property \Illuminate\Support\Carbon|null $endAt 结束时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read string $statusDesc 状态描述
 * @property-read \App\Entities\App|null $app
 * @property-read \App\Entities\CardConditions|null $condition
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CustomerTicketCard[] $records
 * @method static Builder|Card newQuery()
 * @method static Builder|Card query()
 * @method static Builder|Card whereAliAppId($value)
 * @method static Builder|Card whereAppId($value)
 * @method static Builder|Card whereBeginAt($value)
 * @method static Builder|Card whereCardId($value)
 * @method static Builder|Card whereCardInfo($value)
 * @method static Builder|Card whereCardType($value)
 * @method static Builder|Card whereCode($value)
 * @method static Builder|Card wherePlatform($value)
 * @method static Builder|Card whereCreatedAt($value)
 * @method static Builder|Card whereDeletedAt($value)
 * @method static Builder|Card whereEndAt($value)
 * @method static Builder|Card whereId($value)
 * @method static Builder|Card whereIssueCount($value)
 * @method static Builder|Card whereSyncStatus($value)
 * @method static Builder|Card whereStatus($value)
 * @method static Builder|Card whereSync($value)
 * @method static Builder|Card whereUpdatedAt($value)
 * @method static Builder|Card whereUserGetCount($value)
 * @method static Builder|Card whereWechatAppId($value)
 * @mixin \Eloquent
 */
class Card extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess, JsonQuery;

    const SYNC_NO_NEED = -1;
    const SYNC_FAILED = 0;
    const SYNC_ING = 1;
    const SYNC_SUCCESS = 2;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const STATUS_EXPIRE = 2;
    const UNAVAILABLE = 3;

    const CARD_STATUS = [
        self::STATUS_OFF => '未生效',
        self::STATUS_ON => '生效中',
        self::STATUS_EXPIRE => '已失效',
        self::UNAVAILABLE => '已下架',
    ];

    const OWNER_TICKET = 'OWNER_TICKET';
    const ALI_TICKET = 'ALI_TICKET';
    const WX_TICKET = 'WX_TICKET';

    const CARD_CHECKING = CARD_CHECKING;
    const CARD_PASS_CHECK = CARD_PASS_CHECK;
    const CARD_NOT_PASS_CHECK = CARD_NOT_PASS_CHECK;
    const CARD_INVALID = CARD_INVALID;

    const SYNC_STATUS = [
        'CARD_CHECKING' => CARD_CHECKING,
        'CARD_PASS_CHECK' => CARD_PASS_CHECK,
        'CARD_NOT_PASS_CHECK' => CARD_NOT_PASS_CHECK,
        'CARD_INVALID' => CARD_INVALID
    ];
    //'member_card','coupon_card','discount','groupon','gift'
    const MEMBER_CARD = MEMBER_CARD;
    const COUPON_CARD = COUPON_CARD;
    const DISCOUNT = DISCOUNT_CARD;
    const GROUPON = GROUPON_CARD;
    const GIFT = GIFT_CARD;
    const CASH = CASH_CARD;

    const DATE_TYPE_FIX_TIME_RANGE = DATE_TYPE_FIX_TIME_RANGE;

    protected $casts = [
        'card_info' => 'json',
        'begin_at' => 'date',
        'end_at' => 'date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'card_id',
        'card_type',
        'card_info',
        'platform',
        'status',
        'sync_status',
        'sync',
        'app_id',
        'issue_count',
        'wechat_app_id',
        'ali_app_id',
        'begin_at',
        'end_at',
        'user_get_count'
    ];


    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function records(): HasMany
    {
        return $this->hasMany(CustomerTicketCard::class, 'card_id', 'card_id');
    }

    // 优惠券领取条件
    public function condition(): HasMany
    {
        return $this->hasMany(CardConditions::class, 'card_id', 'card_id');
    }

    public function getStatusDescAttribute()
    {
        return self::CARD_STATUS[$this->status];
    }
}
