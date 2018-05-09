<?php

namespace App\Validators\Api;

use App\Validators\Traits\Validator;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class OrderValidator.
 *
 * @package namespace App\Validators\Api;
 */
class OrderValidator extends LaravelValidator
{
    use Validator;
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'total_amount' => ['required', 'numeric'],
            'payment_amount' => ['required', 'numeric'],
            'discount_amount' => ['required', 'numeric', 'min:0']
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
