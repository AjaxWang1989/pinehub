<?php

namespace App\Validators\Admin;

use App\Entities\RechargeableCard;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

/**
 * Class RechargeableCardValidator.
 *
 * @package namespace App\Validators;
 */
class RechargeableCardValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|max:20',
            'amount' => 'nullable|required|integer',
            'price' => 'required|numeric',
            'preferential_price' => 'required|numeric',
            'auto_renew_price' => 'required|numeric',
            'discount' => 'integer',
            'card_type' => 'required|string|in:' . RechargeableCard::CARD_TYPE_DEPOSIT . ',' . RechargeableCard::CARD_TYPE_DISCOUNT,
            'type' => 'required|integer|in:' . RechargeableCard::TYPE_INDEFINITE . ',' . RechargeableCard::TYPE_WEEKLY . ',' . RechargeableCard::TYPE_MONTHLY
                . ',' . RechargeableCard::TYPE_SEASON . ',' . RechargeableCard::TYPE_YEAR . ',' . RechargeableCard::TYPE_CUSTOM . ',' . RechargeableCard::TYPE_TIME_SPECIFIED,
            'unit' => 'nullable|string|max:10|in:' . RechargeableCard::TIME_UNIT_DAY . ',' . RechargeableCard::TIME_UNIT_HOUR
                . ',' . RechargeableCard::TIME_UNIT_MONTH . ',' . RechargeableCard::TIME_UNIT_YEAR,
            'count' => 'required|integer|min:0',
            'usage_scenarios' => 'required|array',
            'status' => 'nullable|integer|in:' . RechargeableCard::STATUS_DEFINED_ONLY . ',' . RechargeableCard::STATUS_ON
                . ',' . RechargeableCard::STATUS_PREFERENTIAL . ',' . RechargeableCard::STATUS_OFF,
            'specified_start' => 'nullable|date',
            'specified_end' => 'nullable|date',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];

}
