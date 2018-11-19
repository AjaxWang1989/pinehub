<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/17
 * Time: 18:07
 */

namespace App\Http\Requests\MiniProgram;

use Illuminate\Foundation\Http\FormRequest;

class StoreSendOrdersRequest extends FormRequest
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
            'send_start_time' => 'required|date',
            'send_end_time'   => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'send_start_time.required' => '配送开始时间不能为空且时间格式要为date',
            'send_end_time.required'   => '配送结束时间不能为空且时间格式要为date',
        ];
    }
}