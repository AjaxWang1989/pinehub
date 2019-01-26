<?php

namespace App\Http\Requests\Admin;

use Urameshibr\Requests\FormRequest;
use App\Entities\Card;
use Illuminate\Validation\Rule;

class MemberCardCreateRequest extends FormRequest
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
            'member_card_info' => ['required', 'array'],
            'member_card_type' => ['required', Rule::in([Card::MEMBER_CARD])],
            'sync'        => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'member_card_info.array'      => 'member_card_info不能为空,且应该是数组',
            'member_card_type.in'         => 'member_card_type不在给定的数组中',
            'sync.required.integer'  => 'sync不能为空且必须为整型',
        ];
    }
}
