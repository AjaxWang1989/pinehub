<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CardCreateRequest extends FormRequest
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
            'ticket_info' => ['required', 'array'],
            'sync' => ['required', 'boolean'],
            'begin_at' => ['required', 'date'],
            'end_at'   => ['required', 'date']
        ];
    }
}
