<?php

namespace App\Http\Requests\Admin;

use App\Entities\Activity;
use App\Entities\PaymentActivity;
use Urameshibr\Requests\FormRequest;
use Illuminate\Validation\Rule;

class OrderGiftUpdateRequest extends FormRequest
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
//            //
            'title'     => ['required','string'],
            'type'      => Rule::in(Activity::NEW_EVENTS_ACTIVITY,Activity::PAYMENT_ACTIVITY),
            'start_at'  => ['required','date'],
            'end_at'    =>['required','date'],
            'payment_activity.*.type'         => Rule::in(PaymentActivity::PAY_FULL,PaymentActivity::PAY_GIFT),
            'payment_activity.*.discount'     => ['numeric'],
            'payment_activity.*.cost'         => ['numeric'],
            'payment_activity.*.least_amount' => ['numeric'],
            'payment_activity.*.score'        => ['integer'],
            'payment_activity.*.ticket_id'    => ['integer'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => '缺少必要参数title',
            'type.in'           => 'type传的参数错误',
            'start_at.required' => '缺少必填参数start_at',
            'end_at.required'   => '缺少必填参数end_at',
            'payment_activity.*.type.in'              => 'paymentActivity表中type传的参数不正确',
            'payment_activity.*.discount.numeric'     => 'discount折扣参数不是数字格式',
            'payment_activity.*.cost.numeric'         => 'cost抵用金额参数不是数字格式',
            'payment_activity.*.least_amount.numeric' => 'least_amount最低消费参数不是数字格式',
            'payment_activity.*.score.integer'        => 'score积分不是整型',
            'payment_activity.*.ticket_id.integer'    => 'ticket_id优惠券id不是整型',
        ];
    }
}
