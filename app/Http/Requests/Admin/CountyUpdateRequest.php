<?php

namespace App\Http\Requests\Admin;

use Urameshibr\Requests\FormRequest;

class CountyUpdateRequest extends FormRequest
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
            'name' => ['required'],
            'code' => ['required'],
            'country_id' => ['exists:countries,id'],
            'province_id' => ['exists:provinces,id'],
            'city_id' => ['exists:cities,id']
        ];
    }
}
