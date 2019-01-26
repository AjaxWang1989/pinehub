<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 3:28
 */

namespace App\Http\Requests\MiniProgram;

use Urameshibr\Requests\FormRequest;

class FeedBackMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comment' => 'required|string',
            'mobile'  => 'mobile',
        ];
    }

    public function messages()
    {
        return [
            'mobile'  => '手机号格式错误',
            'comment.string' => '备注不能为空'
        ];
    }
}