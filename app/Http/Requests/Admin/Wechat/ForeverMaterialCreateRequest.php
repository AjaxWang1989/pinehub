<?php

namespace App\Http\Requests\Admin\Wechat;

use Illuminate\Foundation\Http\FormRequest;

class ForeverMaterialCreateRequest extends FormRequest
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
        $fileField = $this->input('file_field');
        if($this->file($fileField)) {
            return [
                //
                'file_field' => ['required', 'string'],
                $fileField => ['required', 'file']
            ];
        }else {
            return [
                //
                'file_field' => ['required', 'string'],
                'file_path' => ['required', 'file_exist']
            ];
        }

    }
}
