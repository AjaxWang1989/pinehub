<?php

namespace App\Http\Requests\Admin;

use Urameshibr\Requests\FormRequest;


class NewActivityMerchandiseRequest extends FormRequest
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
            'merchandise_id' => ['required', 'exists:merchandises,id'],
            'stock_num' => ['required', 'integer']
        ];
    }
}
