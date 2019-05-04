<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/17
 * Time: 18:07
 */

namespace App\Http\Requests\MiniProgram;

use Dingo\Api\Http\FormRequest;

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
            'date' => 'required|date',
            'batch'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '配送时间',
            'batch.required'   => '配送批次',
        ];
    }
}