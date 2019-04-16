<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketTemplateMessage.
 *
 * 优惠券模板消息
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $ticketId 卡券ID
 * @property int $userTemplateId 自定义模版消息ID
 * @property string $scene 场景
 * @property boolean $isDefault
 * @property int $type
 * @property UserTemplateMessage|null $userTemplateMessage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereUserTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereScene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereType($value)
 * @mixin Eloquent
 */
class TicketTemplateMessage extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'ticket_id', 'user_template_id', 'scene', 'is_default', 'type'];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function userTemplateMessage()
    {
        return $this->belongsTo(UserTemplateMessage::class, 'user_template_id', 'id');
    }
}
