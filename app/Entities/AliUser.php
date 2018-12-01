<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\AliUser
 *
 * @property int $id
 * @property int|null $userId 用户id
 * @property string $appId 系统appid
 * @property string $openId 支付宝user_id
 * @property string|null $avatar 头像
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $nickname 用户昵称
 * @property int $isStudentCertified 是否是学生
 * @property int $userType 用户类型（1/2） 1代表公司账户2代表个人账户
 * @property string $userStatus 用户状态（Q/T/B/W）。 Q代表快速注册用户 T代表已认证用户 
 *             B代表被冻结账户 W代表已注册，未激活的账户
 * @property string $isCertified 是否通过实名认证。T是通过 F是没有实名认证。
 * @property string $gender 【注意】只有is_certified为T的时候才有意义，否则不保证准确性.
 *              性别（F：女性；M：男性）。
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereIsCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereIsStudentCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\AliUser whereUserType($value)
 * @mixin \Eloquent
 */
class AliUser extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
