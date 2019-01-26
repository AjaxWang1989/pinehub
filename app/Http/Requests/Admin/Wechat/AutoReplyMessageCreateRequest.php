<?php

namespace App\Http\Requests\Admin\Wechat;

use Urameshibr\Requests\FormRequest;
use Illuminate\Validation\Rule;

class AutoReplyMessageCreateRequest extends FormRequest
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
            'app_id' => ['required', 'exists:wechat_configs,app_id'],
            'type'   => ['required', Rule::in(WECHAT_AUTO_REPLY_MESSAGE)],
            'content' => ['required', 'string'],
            'prefect_match_keywords' => ['array'],
            'semi_match_keywords' => ['array'],
            'focus_reply' => ['boolean']
        ];
    }
}
