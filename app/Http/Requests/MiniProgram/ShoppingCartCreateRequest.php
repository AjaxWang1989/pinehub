<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 15:59
 */

namespace App\Http\Requests\MiniProgram;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingCartCreateRequest extends FormRequest
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
            'store_id' => 'int',
            'activity_merchandises_id' => 'int',
        ];
    }

}