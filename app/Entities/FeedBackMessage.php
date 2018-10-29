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
 * @property int $id
 * @property string $openId 微信open id或支付宝user ID
 * @property string|null $appId 系统appid
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\FeedBackMessage whereUpdatedAt($value)
 * @mixin \Eloquent
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