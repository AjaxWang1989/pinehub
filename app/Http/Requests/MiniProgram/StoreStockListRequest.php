<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:20
 */

namespace App\Http\Requests\MiniProgram;

use Urameshibr\Requests\FormRequest;

class StoreStockListRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'store_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required.integer' => '店铺分类id不能为空且要是整型',
            'store_id.required.integer' => '店铺id不能为空且要是整型',
        ];
    }
}