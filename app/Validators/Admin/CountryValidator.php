<?php

namespace App\Validators\Admin;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use App\Validators\Traits\Validator;
/**
 * Class CountryValidator.
 *
 * @package namespace App\Validators\Admin;
 */
class CountryValidator extends LaravelValidator
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
            'code' => 'required',
            'name' => 'required|string'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'code' => 'required',
            'name' => 'required|string'
        ],
    ];
}
