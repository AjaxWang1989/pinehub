<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WechatAutoReplyMessage.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $appId 微信app ID
 * @property string $type 类型
 * @property mixed|null $prefectMatchKeywords 全匹配关键字数组
 * @property mixed|null $semiMatchKeywords 半匹配关键字数组
 * @property string $content 回复消息内容
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage wherePrefectMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereSemiMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $focusReply 关注回复
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereFocusReply($value)
 */
class WechatAutoReplyMessage extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'type',
        'prefect_match_keywords',
        'semi_match_keywords',
        'focus_reply',
        'content'
    ];

}
