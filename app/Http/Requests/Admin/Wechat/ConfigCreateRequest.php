<?php

namespace App\Http\Requests\Admin\Wechat;

use Illuminate\Foundation\Http\FormRequest;

class ConfigCreateRequest extends FormRequest
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
            'app_id' => ['required', 'regex:'.WECHAT_APP_ID],
            'app_secret' => ['required', 'regex:'.WECHAT_APP_SECRET],
            'app_name' => ['required', 'string'],
            'token' => ['required_if:mode,'.WECHAT_DEVELOPER_MODE, 'regex:'.WECHAT_APP_SECRET],
            'aes_key' => ['required_if:mode,'.WECHAT_DEVELOPER_MODE, 'regex:'.WECHAT_AES_KEY],
            'type' => ['required', 'in:'.WECHAT_OFFICE_ACCOUNT.','.WECHAT_OPEN_PLATFORM.','.WECHAT_MINI_PROGRAM],
            'mode' => ['required', 'in:'.WECHAT_EDITOR_MODE.','.WECHAT_DEVELOPER_MODE],
            'wechat_bind_app' => ['in:'.GK_APP_NAME.','.TO_APP_NAME, "not_exists:wechat_configs"]
        ];
    }
}
