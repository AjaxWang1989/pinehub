<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * App\Entities\WechatMaterial
 *
 * @property int $id
 * @property string $title 素材名称
 * @property string $introduction 素材介绍
 * @property int $isTmp 是否临时素材
 * @property string $mediaId 素材id
 * @property string $url 图片url
 * @property string $type 图片（image）: 2M，支持bmp/png/jpeg/jpg/gif格式;
 *             语音（voice）：2M，播放长度不超过60s，mp3/wma/wav/amr格式;视频（video）：10MB，支持MP4格式;缩略图（thumb）：64KB，支持JPG格式;图文（news）
 * @property array $articles 图文
 * @property \Illuminate\Support\Carbon $expiresAt 临时素材过期时间
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereArticles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereIsTmp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WechatMaterial whereUrl($value)
 * @mixin \Eloquent
 */
class WechatMaterial extends Model implements Transformable
{
    use TransformableTrait,ModelAttributesAccess;

    protected $casts = [
        'articles' => 'json',
        'expires_at' => 'date',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','introduction','is_tmp','media_id','url','type','articles','expires_at'
    ];

}
