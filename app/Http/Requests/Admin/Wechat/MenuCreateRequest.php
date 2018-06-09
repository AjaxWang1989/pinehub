<?php

namespace App\Http\Requests\Admin\Wechat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuCreateRequest extends FormRequest
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
            "button" => ['required', 'array'],
            "button.*.name" => ['required', 'string'],
            "button.*.type" => ["required", Rule::in(WECHAT_MENU_TYPE)],
            "button.*.url" => ["url"],
            "button.*.key" => ["string"],
            "button.*.sub_button" => ['array'],
            "button.*.sub_button.*.name" => ['string'],
            "button.*.sub_button.*.type" => [ Rule::in(WECHAT_MENU_TYPE)],
            "button.*.sub_button.*.url" => ["url"],
            "button.*.sub_button.*.key" => ["string"],
        ];
    }
}
