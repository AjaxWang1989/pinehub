<?php

namespace App\Http\Requests\Admin\Wechat;

use Illuminate\Foundation\Http\FormRequest;

class AutoReplyMessageUpdateRequest extends FormRequest
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
            'type'   => [ Rule::in(WECHAT_AUTO_REPLY_MESSAGE)],
            'content' => [ 'string'],
            'prefect_match_keywords' => ['array'],
            'semi_match_keywords' => ['array'],
        ];
    }
}
