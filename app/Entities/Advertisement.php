<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-19
 * Time: 下午3:44
 */

namespace App\Entities;

use App\Entities\Traits\JsonQuery;
use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Advertisement
 *
 * @property int $id
 * @property string $title 广告投放标题
 * @property string $appId 系统app id
 * @property string $wechatAppId 微信app id
 * @property string $bannerUrl 广告图片地址
 * @property $cardId 广告关联优惠券
 * @property $conditions 广告投放条件
 * @property $beginAt 广告开始投放时间
 * @property $endAt 广告结束投放时间
 * @property $status 状态
 * @property-read $ticket 优惠券
 * @property-read $statusDesc 状态描述
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Advertisement whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Advertisement whereWechatAppId($value)
 */
class Advertisement extends Model
{
    use TransformableTrait, ModelAttributesAccess, JsonQuery;

    protected $fillable = ['title', 'app_id', 'wechat_app_id', 'banner_url', 'card_id', 'conditions', 'begin_at', 'end_at', 'status'];

    protected $casts = [
        'conditions' => 'array'
    ];

    protected $dates = ['begin_at', 'end_at'];

    const STATUS_WAIT = 0;
    const STATUS_ON = 1;
    const STATUS_EXPIRE = 2;
    const STATUS_UNAVAILABLE = 3;

    const STATUS = [
        self::STATUS_WAIT => '未投放',
        self::STATUS_ON => '投放中',
        self::STATUS_EXPIRE => '已过期',
        self::STATUS_UNAVAILABLE => '已下架'
    ];

    // 关联卡券
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'card_id', 'card_id');
    }

    public function getStatusDescAttribute()
    {
        return self::STATUS[$this->status];
    }
}