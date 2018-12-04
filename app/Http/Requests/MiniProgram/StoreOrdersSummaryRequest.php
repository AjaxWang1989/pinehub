<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/17
 * Time: 17:49
 */

namespace App\Http\Requests\MiniProgram;

use App\Entities\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreOrdersSummaryRequest extends FormRequest
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
            'paid_date' => 'required|date',
            'type'            => Rule::in(null, Order::SHOPPING_MALL_ORDER, Order::SITE_USER_ORDER),
            'status'          => Rule::in('all','send','completed')
        ];
    }

    public function messages()
    {
        return [
            'paid_date.required' => '支付开始时间不能为空且格式要为date',
            'type.in'        => 'type不在定义的字符串中',
            'status.in'      => 'status不在定义的字符串中'
        ];
    }
}