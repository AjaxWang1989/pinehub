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
            'send_time' => 'date',
            'card_id' => 'int',
            'store_id' => 'int',
            'activity_merchandises_id' =>'int'
        ];
    }

    public function messages()
    {
        return [
          'receiver_mobile.mobile' => '手机号格式错误'
        ];
    }
}