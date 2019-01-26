<?php

namespace App\Http\Requests\Admin;

use Urameshibr\Requests\FormRequest;

class CityCreateRequest extends FormRequest
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
            'code' => ['required'],
            'name' => ['required'],
            'country_id' => ['exists:countries,id'],
            'province_id' => ['exists:provinces,id']
        ];
    }
}
