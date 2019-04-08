<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserTemplateMessage.
 *
 * 系统定制模板消息库
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $wxAppId
 * @property int $type
 * @property int $templateId
 * @property string $content
 * @property WxTemplateMessage $wxTemplateMessage
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereWxAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTemplateMessage whereUpdatedAt($value)
 */
class UserTemplateMessage extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['wx_app_id', 'type', 'template_id', 'content'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];

    public function wxTemplateMessage(): BelongsTo
    {
        return $this->belongsTo(WxTemplateMessage::class, 'template_id');
    }
}
