<?php

namespace App\Validators\Admin;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class GetUsersValidator.
 *
 * @package namespace App\Validators\Admin;
 */
class UsersValidator extends LaravelValidator
{
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
            'password' => ['required', 'string']
        ],
    ];
}
