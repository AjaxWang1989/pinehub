<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\WechatAutoReplyMessage
 *
 * @property int $id
 * @property string $appId 微信app ID
 * @property string|null $name 规则名称
 * @property int $focusReply 关注回复
 * @property string $type 类型
 * @property array $prefectMatchKeywords 全匹配关键字数组
 * @property array $semiMatchKeywords 半匹配关键字数组
 * @property string $content 回复消息内容
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereFocusReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage wherePrefectMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereSemiMatchKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatAutoReplyMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $appId 微信app ID
 * @property int $focusReply 关注回复
 * @property array $prefectMatchKeywords 全匹配关键字数组
 * @property array $semiMatchKeywords 半匹配关键字数组
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 */
class WechatAutoReplyMessage extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $casts = [
        'prefect_match_keywords' => 'array',
        'semi_match_keywords' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'name',
        'type',
        'prefect_match_keywords',
        'semi_match_keywords',
        'focus_reply',
        'content'
    ];

}
