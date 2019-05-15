<?php
/**
 * RechargeableCard.php
 * User: katherine
 * Date: 19-5-13 下午5:19
 */

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Entities\RechargeableCard
 *
 * @property int $id
 * @property string $name 卡种名称
 * @property int $amount 卡内金额（分）
 * @property int $price 售价（分）
 * @property int $preferentialPrice 优惠价格（分）
 * @property int $autoRenewPrice 自动续费价格（分）
 * @property bool $onSale 是否优惠
 * @property bool $isRecommend 是否推荐
 * @property int $discount 卡种享受购买折扣（百分比）
 * @property string $cardType 卡种
 * @property-read string $cardTypeDesc 卡种中文描述
 * @property int $type 卡种期限类型
 * @property-read string $typeDesc 卡种期限类型中文描述
 * @property string $unit 时间单位
 * @property int $count 有限期数量，结合时间单位
 * @property array $usageScenarios 使用场景，默认全场通用
 * @property-read array $usageScenariosDesc 使用场景中文描述
 * @property Carbon|null $specifiedStart 特定时段开始/天
 * @property Carbon|null $specifiedEnd 特定时段结束/天
 * @property int $status 卡种状态，0=>暂未上架,11=>上架,12=>优惠,21=>删除
 * @property-read string $statusDesc
 * @property int $sort 排序，升序，最大值255
 * @property Carbon|null $deletedAt 删除时间，下架时间
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property-read Collection|Ticket[] $giftTickets
 * @method static bool|null forceDelete()
 * @method static Builder|RechargeableCard newModelQuery()
 * @method static Builder|RechargeableCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|RechargeableCard onlyTrashed()
 * @method static Builder|RechargeableCard query()
 * @method static bool|null restore()
 * @method static Builder|RechargeableCard whereAmount($value)
 * @method static Builder|RechargeableCard whereAutoRenewPrice($value)
 * @method static Builder|RechargeableCard whereCardType($value)
 * @method static Builder|RechargeableCard whereCount($value)
 * @method static Builder|RechargeableCard whereCreatedAt($value)
 * @method static Builder|RechargeableCard whereDeletedAt($value)
 * @method static Builder|RechargeableCard whereDiscount($value)
 * @method static Builder|RechargeableCard whereId($value)
 * @method static Builder|RechargeableCard whereIsRecommend($value)
 * @method static Builder|RechargeableCard whereName($value)
 * @method static Builder|RechargeableCard whereOnSale($value)
 * @method static Builder|RechargeableCard wherePreferentialPrice($value)
 * @method static Builder|RechargeableCard wherePrice($value)
 * @method static Builder|RechargeableCard whereSort($value)
 * @method static Builder|RechargeableCard whereSpecifiedEnd($value)
 * @method static Builder|RechargeableCard whereSpecifiedStart($value)
 * @method static Builder|RechargeableCard whereStatus($value)
 * @method static Builder|RechargeableCard whereType($value)
 * @method static Builder|RechargeableCard whereUnit($value)
 * @method static Builder|RechargeableCard whereUpdatedAt($value)
 * @method static Builder|RechargeableCard whereUsageScenarios($value)
 * @method static \Illuminate\Database\Query\Builder|RechargeableCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RechargeableCard withoutTrashed()
 * @mixin \Eloquent
 */
class RechargeableCard extends Model
{
    use SoftDeletes, ModelAttributesAccess;

    protected $fillable = [
        'name', 'amount', 'price', 'preferential_price', 'auto_renew_price', 'on_sale', 'is_recommend', 'discount', 'card_type', 'type', 'unit', 'count',
        'usage_scenarios', 'status', 'specified_start', 'specified_end', 'sort'
    ];

    protected $casts = [
        'on_sale' => 'boolean',
        'is_recommend' => 'boolean',
        'usage_scenarios' => 'array'// 使用场景
    ];

    protected $dates = [
        'deleted_at'
    ];

    public $moneyFields = ['price', 'amount', 'preferential_price', 'auto_renew_price'];

    const CARD_TYPE_DEPOSIT = 'DEPOSIT';
    const CARD_TYPE_DISCOUNT = 'DISCOUNT';
    const CARD_TYPES = [
        self::CARD_TYPE_DEPOSIT => '储值卡',
        self::CARD_TYPE_DISCOUNT => '折扣卡'
    ];

    const TYPE_INDEFINITE = 101;// 无限期
    const TYPE_WEEKLY = 201;// 周卡
    const TYPE_MONTHLY = 202;// 月卡
    const TYPE_SEASON = 203;// 季卡
    const TYPE_YEAR = 204;// 年卡
    const TYPE_CUSTOM = 205;// 自定义
    const TYPE_TIME_SPECIFIED = 206;// 特定时段/天有限期(保留项)
    const LIMIT_TYPES = [
        self::TYPE_INDEFINITE => '无限期',
        self::TYPE_WEEKLY => '周卡',
        self::TYPE_MONTHLY => '月卡',
        self::TYPE_SEASON => '季卡',
        self::TYPE_YEAR => '年卡',
        self::TYPE_CUSTOM => '自定义',
        self::TYPE_TIME_SPECIFIED => '特定时段/天',
    ];

    const STATUS_DEFINED_ONLY = 0;// 仅定义
    const STATUS_ON = 11;// 上架
    const STATUS_PREFERENTIAL = 12;// 上架&优惠
    const STATUS_OFF = 21;// 下架
    const CARD_STATUS = [
        self::STATUS_DEFINED_ONLY => '新建未上架',
        self::STATUS_ON => '上架',
        self::STATUS_PREFERENTIAL => '上架&优惠',
        self::STATUS_OFF => '下架'
    ];

    // 时间单位
    const TIME_UNIT_YEAR = 'year';
    const TIME_UNIT_MONTH = 'month';
    const TIME_UNIT_DAY = 'day';
    const TIME_UNIT_HOUR = 'hour';

    // 附赠优惠券
    public function giftTickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'rechargeable_card_tickets', 'rechargeable_card_id', 'ticket_id');
    }

    // 卡种中文描述
    public function getCardTypeDescAttribute(): string
    {
        return self::CARD_TYPES[$this->cardType];
    }

    // 卡描述---限期类型
    public function getTypeDescAttribute(): string
    {
        return self::LIMIT_TYPES[$this->type];
    }

    // 卡种状态描述
    public function getStatusDescAttribute(): string
    {
        return self::CARD_STATUS[$this->status];
    }

    // 使用场景中文描述
    public function getUsageScenariosDescAttribute(): array
    {
        $usageScenariosDesc = [];
        foreach ($this->usageScenarios as $usageScenario) {
            $usageScenariosDesc[] = TICKET_SCENARIOS[$usageScenario];
        }
        return $usageScenariosDesc;
    }
}