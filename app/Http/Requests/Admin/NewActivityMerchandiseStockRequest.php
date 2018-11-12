<?php

namespace App\Http\Requests\Admin;

use AlbertCht\Form\FormRequest;


class NewActivityMerchandiseStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'stock_num' => ['required', 'integer', 'min:1']
        ];
    }
}
