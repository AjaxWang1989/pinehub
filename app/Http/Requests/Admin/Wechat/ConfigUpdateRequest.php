<?php

namespace App\Http\Requests\Admin\Wechat;

use Urameshibr\Requests\FormRequest;
use Illuminate\Validation\Rule;

class ConfigUpdateRequest extends FormRequest
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
            'app_secret' => ['regex:'.WECHAT_APP_SECRET],
            'app_name' => ['string'],
            'token' => ['required_if:mode,'.WECHAT_DEVELOPER_MODE , 'regex:'.WECHAT_APP_SECRET],
            'aes_key' => ['required_if:mode,'.WECHAT_DEVELOPER_MODE, 'regex:'.WECHAT_AES_KEY],
            'type' => ['in:'.WECHAT_OFFICIAL_ACCOUNT.','.WECHAT_OPEN_PLATFORM.','.WECHAT_MINI_PROGRAM],
            'mode' => ['in:'.WECHAT_EDITOR_MODE.','.WECHAT_DEVELOPER_MODE],
            'wechat_bind_app' => ['in:'.GK_APP_NAME.','.TO_APP_NAME]
        ];
    }
}
