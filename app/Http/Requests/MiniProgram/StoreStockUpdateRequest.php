<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:09
 */

namespace App\Http\Requests\MiniProgram;

use Dingo\Api\Http\FormRequest;


class StoreStockUpdateRequest extends FormRequest
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
            'primary_stock_num' => 'required|numeric',
            'modify_stock_num' => 'required|numeric',
            'reason' => 'string',
            'comment' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'primary_stock_num.numeric' => '原库存不能为空切必须是数字',
            'modify_stock_num.numeric' => '修改后库存不能为空切必须是数字',
            'reason.string' => '原因格式不是字符串类型',
            'comment.string' => '备注格式不是字符串类型'
        ];
    }

}