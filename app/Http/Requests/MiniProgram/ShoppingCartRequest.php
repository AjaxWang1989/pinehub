<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 15:59
 */

namespace App\Http\Requests\MiniProgram;

use Dingo\Api\Http\FormRequest;

class ShoppingCartRequest extends FormRequest
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
            'merchandise_id' => 'required|integer',
            'quality'        => 'required|integer',
            'date'           => 'required|date',
            'batch'          => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'merchandise_id.required' => '商品id不能为空且格式要为整型',
            'quality.required'        => '商品数量不能为空且必须为整数',
            'date.date'               => '配送时间不是格式化时间',
            'batch.integer'           => '配送批次必须是整数'
        ];
    }
}