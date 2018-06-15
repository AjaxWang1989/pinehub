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
            "name" => ['string'],
            "menus" => ['json'],
            "menus.button" => ['required', 'array'],
            "menus.button.*.name" => ['required', 'string'],
            "menus.button.*.type" => ["required", Rule::in(WECHAT_MENU_TYPE)],
            "menus.button.*.url" => ["url"],
            "menus.button.*.key" => ["string"],
            "menus.button.*.sub_button" => ['array'],
            "menus.button.*.sub_button.*.name" => ['string'],
            "menus.button.*.sub_button.*.type" => [ Rule::in(WECHAT_MENU_TYPE)],
            "menus.button.*.sub_button.*.url" => ["url"],
            "menus.button.*.sub_button.*.key" => ["string"],
        ];
    }
}
