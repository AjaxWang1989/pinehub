<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PaymentConfig.
 * 支付模板消息配置
 * @property int $id
 * @property string $type  支付类型 ALI，WX，OTHER
 * @property bool $needSendTemplateMessage 是否开启模板消息推送
 * @property int $userTemplateId 自定义模板消息
 * @property array $configs 配置详情
 * @package namespace App\Entities;
 */
class PaymentConfig extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'need_send_template_message', 'user_template_id', 'configs'];

    protected $casts = [
        'configs' => 'json',
        'need_send_template_message' => 'boolean',
    ];

    public function templateMessage()
    {
        return $this->belongsTo(UserTemplateMessage::class, 'user_template_id', 'id');
    }
}
