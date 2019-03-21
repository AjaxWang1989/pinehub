<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderSendRequest extends FormRequest
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
        //0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运
        return [
            //
            'post_type' => ['required', Rule::in([0, 1000, 2000, 3000, 4000, 5000, 6000])],
            'post_no'   => ['required', 'string', 'max:32'],
            'post_name' => ['required', 'string', 'max:64']
        ];
    }
}
