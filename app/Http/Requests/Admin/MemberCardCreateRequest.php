<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
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
            'member_info' => ['required', 'array'],
            'ticket_type' => ['required', Rule::in([Card::MEMBER_CARD])],
            'sync'        => ['required', 'integer'],
            'begin_at'    => ['date'],
            'end_at'      => ['date']
        ];
    }

    public function messages()
    {
        return [
            'member_info.array'      => 'member_info不能为空,且应该是数组',
            'ticket_type.in'         => 'ticket_type不在给定的数组中',
            'sync.required.integer'  => 'sync不能为空且必须为整型',
            'begin_at.date'          => 'begin_at必须为date类型',
            'end_at.date'            => 'end_at必须为date类型'
        ];
    }
}
