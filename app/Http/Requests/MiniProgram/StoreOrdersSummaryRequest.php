<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/17
 * Time: 17:49
 */

namespace App\Http\Requests\MiniProgram;

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
            'paid_start_time' => 'required|date',
            'paid_end_time'   => 'required|date',
            'type'            => Rule::in('reserve','self_lift'),
            'status'          => Rule::in('all','send','completed')
        ];
    }

    public function messages()
    {
        return [
            'paid_start_time.required' => '支付开始时间不能为空且格式要为date',
            'paid_end_time.required'   => '支付结束时间不能为空且格式要为date',
            'type'        => 'type不在定义的字符串中',
            'status'      => 'status不在定义的字符串中'
        ];
    }
}