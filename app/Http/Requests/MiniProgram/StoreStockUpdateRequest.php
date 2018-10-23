<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:09
 */

namespace App\Http\Requests\MiniProgram;

use Illuminate\Foundation\Http\FormRequest;


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
            //
            'merchandise_id' => 'required|int',
            'primary_stock_num' => 'required|int',
            'modify_stock_num' => 'required|int',
            'reason' => 'string',
            'comment' => 'string'
        ];
    }

}