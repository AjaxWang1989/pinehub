<?php

namespace App\Validators\Auth;

use App\Validators\Traits\Validator;
use Illuminate\Validation\Rule;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators\Auth;
 */
class UserValidator extends LaravelValidator
{
    use Validator;
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'mobile' => ['required', 'unique:users', 'regex:'.MOBILE_PATTERN],
            'password' => ['required', 'string']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'mobile' => ['unique:users', 'regex:'.MOBILE_PATTERN],
            'password' => ['string'],
            'user_name' => ['unique', 'string', 'size:'.USER_NAME_MAX_LENGTH],
            'nickname'  => ['string', 'size:'.USER_NAME_MAX_LENGTH],
            'real_name' => ['string', 'size:'.USER_NAME_MAX_LENGTH],
            'sex'       => ['string', 'in:'.UNKNOWN.','.MALE.','.FEMALE],
            'avatar'    => ['string', 'regex:'.IMAGE_URL_PATTERN],
            'city'      => ['string']
        ],
    ];
}
