<?php

namespace App\Validators\Admin;

use App\Validators\Traits\Validator;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ShopsValidator.
 *
 * @package namespace App\Validators\Admin;
 */
class ShopsValidator extends LaravelValidator
{
    use Validator;
    protected $input = null;
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
