<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:50
 */

namespace App\Http\Requests\MiniProgram;

use App\Entities\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class OrderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'receiver_name' => 'required|string',
            'receiver_address' => 'required|string',
            'receiver_mobile' => 'required|mobile',
            'comment' => 'string',
            'type' => Rule::in(Order::OFF_LINE_PAY,Order::ORDERING_PAY,Order::E_SHOP_PAY,Order::SITE_SELF_EXTRACTION,Order::SITE_DISTRIBUTION,Order::ACTIVITY_PAY),
            'send_batch' => 'integer',
            'send_time' => 'array',
            'card_id' => 'string',
            'store_id' => 'integer',
            'activity_id' => 'integer',
            'activity_merchandises_id' =>'integer'
        ];
    }

    public function messages()
    {
        return [
            'receiver_name.required' => '姓名不能为空',
            'receiver_mobile.mobile' => '手机号格式错误',
            'receiver_address.required' => '地址不能为空',
            'comment.string' => '备注不是字符串类型',
            'type' => 'type不在给定的数字中',
            'send_time.array' => '配送时间不是一个数组',
            'card_id.string' => '优惠券id字符串类型',
            'store_id.integer' => '店铺id不是整型',
            'activity_id.integer' => '活动id不是整型',
            'activity_merchandises_id.integer' => '活动商品id不是整型'
        ];
    }
}