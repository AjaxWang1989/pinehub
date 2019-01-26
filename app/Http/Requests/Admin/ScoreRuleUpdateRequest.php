<?php

namespace App\Http\Requests\Admin;

use App\Entities\ScoreRule;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScoreRuleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'score' => ['integer'],
            'type' => [Rule::in([ScoreRule::SPECIAL_RULE, ScoreRule::ORDER_AMOUNT_RULE,
                ScoreRule::ORDER_COUNT_RULE, ScoreRule::SUBSCRIBE_RULE, ScoreRule::GENERAL_RULE])],
            'expires_at' => ['date'],
            'notice_user' => ['boolean'],
            'rule' => ['array']
        ];
    }
}
