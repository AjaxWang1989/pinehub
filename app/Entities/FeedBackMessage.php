<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/22
 * Time: 18:15
 */

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * App\Entities\App
 *
 * @property string $customerId 用户id
 * @property string $openid 微信open id或支付宝user ID
 * @property string $comment 反馈内容
 * @property string $mobile 电话
 * @property string $appID 系统app_id
 */

class FeedBackMessage extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    protected $table = 'feed_back_message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'open_id',
        'app_id',
        'comment',
        'mobile'
    ];
}