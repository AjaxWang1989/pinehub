<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PaymentConfig.
 * 支付模板消息配置
 * @package namespace App\Entities;
 */
class PaymentConfig extends Model implements Transformable
{
    use TransformableTrait;

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
}
