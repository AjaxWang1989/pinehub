<?php

namespace App\Entities;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketTemplateMessage.
 *
 * 优惠券模板消息
 *
 * @package namespace App\Entities;
 * @property int $ticketId 卡券ID
 * @property int $userTemplateId 自定义模版消息ID
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\TicketTemplateMessage whereUserTemplateId($value)
 * @mixin Eloquent
 */
class TicketTemplateMessage extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_id', 'user_template_id'];

}
