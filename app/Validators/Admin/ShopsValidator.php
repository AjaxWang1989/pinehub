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
            'name' => [ 'string', 'size:32'],
            'user_id' => ['integer'],
            'description' => ['string'],
            'country_id'     => ['required', 'integer'],
            'province_id'    => ['required', 'integer'],
            'city_id'        => ['required', 'integer'],
            'county_id'      => ['required', 'integer'],
            'address'        => ['required', 'string'],
            'position'       => ['required']
        ],
        ValidatorInterface::RULE_UPDATE => [
            //'name' => [ 'string', 'max:255'],
            'manager_mobile' => ['regex:'.MOBILE_PATTERN],
            'manager_name'   => ['string', 'max:255'],
            'description' => ['string'],
            'country_id'     => [ 'integer'],
            'province_id'    => [ 'integer'],
            'city_id'        => [ 'integer'],
            'county_id'      => [ 'integer'],
            'address'        => ['string']
        ],
    ];
}
