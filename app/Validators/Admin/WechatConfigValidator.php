<?php

namespace App\Validators\Admin;

use Illuminate\Validation\Rule;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class WechatConfigValidator.
 *
 * @package namespace App\Validators\Admin;
 */
class WechatConfigValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'app_id' => ['required', 'regex:'.WECHAT_APP_ID],
            'app_secret' => ['required', 'regex:'.WECHAT_APP_SECRET],
            'token' => ['regex:'.WECHAT_APP_SECRET],
            'aes_key' => ['regex:'.WECHAT_AES_KEY],
            'type' => ['required', 'in:'.WECHAT_OFFICE_ACCOUNT.','.WECHAT_OPEN_PLATFORM.','.WECHAT_MINI_PROGRAM],
            'mode' => ['required', 'in:'.WECHAT_EDITOR_MODE.','.WECHAT_DEVELOPER_MODE],
            'wechat_bind_app' => ['in:'.GK_APP_NAME.','.TO_APP_NAME]
        ],
        ValidatorInterface::RULE_UPDATE => [
            'app_secret' => ['required', 'regex:'.WECHAT_APP_SECRET],
            'token' => ['regex:'.WECHAT_APP_SECRET],
            'aes_key' => ['regex:'.WECHAT_AES_KEY],
            'type' => ['required', 'in:'.WECHAT_OFFICE_ACCOUNT.','.WECHAT_OPEN_PLATFORM.','.WECHAT_MINI_PROGRAM],
            'mode' => ['required', 'in:'.WECHAT_EDITOR_MODE.','.WECHAT_DEVELOPER_MODE],
            'wechat_bind_app' => ['in:'.GK_APP_NAME.','.TO_APP_NAME]
        ],
    ];
}
