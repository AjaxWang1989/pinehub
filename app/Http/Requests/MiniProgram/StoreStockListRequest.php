<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:20
 */

namespace App\Http\Requests\MiniProgram;

use Illuminate\Foundation\Http\FormRequest;

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
            'category_id' => 'required|int',
            'store_id' => 'required|int',
        ];
    }
}