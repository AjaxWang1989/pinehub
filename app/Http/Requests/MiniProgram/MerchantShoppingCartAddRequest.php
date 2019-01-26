<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/12/6
 * Time: 10:24 PM
 */

namespace App\Http\Requests\MiniProgram;


use Urameshibr\Requests\FormRequest;

class MerchantShoppingCartAddRequest extends FormRequest
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
            'quality'        => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'merchandise_id.required' => '商品id不能为空且格式要为整型',
            'quality.required'        => '商品数量不能为空且必须为整数'
        ];
    }

}