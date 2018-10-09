<?php

namespace App\Http\Requests\Admin;

use App\Entities\Card;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardUpdateRequest extends FormRequest
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
            'ticket_type' => ['required', Rule::in([Card::COUPON_CARD, Card::GROUPON, Card::GIFT, Card::DISCOUNT, Card::CASH])],
            'ticket_info' => ['required', 'array'],
            'sync' => ['required', 'boolean'],
            'begin_at' => ['date'],
            'end_at'   => ['date']
        ];
    }
}
