<?php
/**
 * RechargeableCard.php
 * User: katherine
 * Date: 19-5-13 下午5:19
 */

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RechargeableCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'amount', 'price', 'preferential_price', 'auto_renew_price', 'on_sale', 'is_recommend', 'discount', 'type', 'unit', 'count',
        'usage_scenarios', 'status', 'specified_start', 'specified_end', 'sort', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'on_sale' => 'boolean',
        'is_recommend' => 'boolean',
        'usage_scenarios' => 'array'// 使用场景
    ];

    protected $dates = [
        'deleted_at',
        'specified_start',
        'specified_end'
    ];

    const CARD_TYPE_DEPOSIT = 1;
    const CARD_TYPE_DISCOUNT = 2;
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

    const STATUS_ON = 11;// 上架
    const STATUS_PREFERENTIAL = 12;// 上架&优惠
    const STATUS_OFF = 21;// 下架

    // 时间单位
    const TIME_UNITS = [
        'year', 'month', 'day', 'hour'
    ];

    // 附赠优惠券
    public function giftTickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'rechargeable_card_tickets', 'rechargeable_card_id', 'ticket_id');
    }
}