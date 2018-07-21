<?php

namespace App\Http\Requests\Admin;

use App\Entities\OrderGift;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderGiftUpdateRequest extends FormRequest
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
            'name' => ['required'],
            'begin_at' => ['required', 'date', 'before:end_at'],
            'end_at' => ['required', 'date', 'after:begin_at'],
            'gift' => ['required', 'array'],
            'type' => ['required', Rule::in([OrderGift::PAY_FULL, OrderGift::PAY_GIFT])],
            'status' => ['required', Rule::in([OrderGift::WAIT, OrderGift::RUNNING, OrderGift::END, OrderGift::INVALID])]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '缺少必填参数name',
            'begin_at.required' => '缺少必填参数begin_at',
            'end_at.required' => '缺少必填参数end_at',
            'gift.required' => '缺少必填参数gift',
            'type.required' => '缺少必填参数type',
            'status.required' => '缺少必填参数status',
            'begin_at.date' => 'begin_at参数类型错误，必须是时间格式数据Y-m-d h:m:s',
            'end_at.date' => 'end_at参数类型错误，必须是时间格式数据Y-m-d h:m:s',
            'gift.array' => 'gift为json格式数据',
            'type.in' => '参数type取值必须为 '.OrderGift::PAY_GIFT.'或'.OrderGift::PAY_FULL,
            'status.in' => '参数status取值 '.OrderGift::WAIT.':未开始，'.OrderGift::RUNNING.':进行中，'.
                OrderGift::END.':结束， '.OrderGift::INVALID.': 失效',
            'begin_at.before' => 'begin_at时间必须小于end_at',
            'end_at.after' => 'end_at必须大于begin_at',
        ]; // TODO: Change the autogenerated stub
    }
}
