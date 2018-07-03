<?php

namespace App\Http\Requests\Admin;

use App\Entities\ScoreRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScoreRuleCreateRequest extends FormRequest
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
            'score' => ['required', 'integer'],
            'type' => ['required', Rule::in([ScoreRule::SPECIAL_RULE, ScoreRule::ORDER_AMOUNT_RULE,
                ScoreRule::ORDER_COUNT_RULE, ScoreRule::SUBSCRIBE_RULE])],
            'expires_at' => ['date'],
            'notice_user' => ['required', 'boolean'],
            'rule' => ['json']
        ];
    }
}
