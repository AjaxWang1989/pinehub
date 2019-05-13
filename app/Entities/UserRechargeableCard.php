<?php
/**
 * UserRechargeableCard.php
 * User: katherine
 * Date: 19-5-13 下午5:32
 */

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRechargeableCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'rechargeable_card_id', 'order_id', 'amount', 'invalid_at', 'is_auto_renew', 'status'
    ];

    // 所属订单
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // 所属用户
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}