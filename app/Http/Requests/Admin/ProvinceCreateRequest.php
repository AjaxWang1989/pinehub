<?php

namespace App\Http\Requests\Admin;

use Dingo\Api\Http\FormRequest;

class ProvinceCreateRequest extends FormRequest
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
            'country_id' => ['exists:countries,id']
        ];
    }
}
