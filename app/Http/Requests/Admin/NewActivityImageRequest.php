<?php

namespace App\Http\Requests\Admin;

use Dingo\Api\Http\FormRequest;

class NewActivityImageRequest extends FormRequest
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
        $fileField = $this->input('file_field', 'file');
        return [
            //
            $fileField => ['required', 'mimes:png,jpg,jpeg', 'max:2048']
        ];
    }
}
