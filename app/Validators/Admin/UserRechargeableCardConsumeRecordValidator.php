<?php

namespace App\Validators\Admin;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

/**
 * Class UserRechargeableCardConsumeRecordValidator.
 *
 * @package namespace App\Validators;
 */
class UserRechargeableCardConsumeRecordValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
