<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
//            'background_pic_url' => ['url'],
//            'base_info' => ['required', 'json'],
//            'base_info.logo_url' => ['url'],
//            'base_info.brand_name' => ['string'],
//            'base_info.code_type' => ['in:CODE_TYPE_TEXT,CODE_TYPE_BARCODE,CODE_TYPE_QRCODE,CODE_TYPE_ONLY_QRCODE,
//            CODE_TYPE_ONLY_BARCODE,CODE_TYPE_NONE'],//"CODE_TYPE_TEXT" 文本 "CODE_TYPE_BARCODE"// 一维码 "CODE_TYPE_QRCODE" 二维码
//            // "CODE_TYPE_ONLY_QRCODE" 仅显示二维码 "CODE_TYPE_ONLY_BARCODE" 仅显示一维码 "CODE_TYPE_NONE" 不显示任何码型
//            'base_info.pay_info' => ['json'],
//            'base_info.swipe_card' => ['json'],
//            'base_info.is_swipe_card' => ['boolean'],
//            'base_info.is_pay_and_qrcode' => ['boolean'],
//            'base_info.brand_name' => ['string', 'max:12'],
//            'base_info.notice' => ['string', 'max:16'],
//            'base_info.description' => ['string', 'max:1024'],
//            'base_info.sku' => ['json'],
//            'base_info.quantity' => ['integer', 'min:0', 'max:100000000'],
//            'base_info.date_info' => ['json'],
//            'base_info.title' => ['string', 'max:9'],
//            'base_info.color' => ['string', 'regex:/^Color((0[1-9][0-9])|(100))$/'],
//            'base_info.type' => ['string', 'in:DATE_TYPE_PERMANENT,DATE_TYPE_FIX_TIME_RANGE,DATE_TYPE_FIX_TERM'],
//            'advanced_info' => ['json'],
//            'supply_bonus' => ['boolean'],
//            'supply_balance' => ['boolean'],
//            'prerogative' => ['required', 'string', 'max:1024'],
//            'auto_activate' => ['boolean'],
//            'custom_field1' => ['json'],
//            'activate_url' => ['url'],
//            'custom_cell1' => ['json'],
//            'bonus_rule' => ['json'],
//            'discount'  => ['integer']

        ];
    }
}
