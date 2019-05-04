<?php

namespace App\Validators\Admin;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use App\Validators\Traits\Validator;
/**
 * Class CountyValidator.
 *
 * @package namespace App\Validators\Admin;
 */
class CountyValidator extends LaravelValidator
{
    use Validator;
    protected $input = null;
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
