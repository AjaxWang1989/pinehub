<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-4
 * Time: 上午11:25
 */

namespace App\Http\Requests\Admin\Wechat;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserTemplateMessageCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => ['required', Rule::in(TEMPLATE_MESSAGE_TYPES)],
            'template_id' => ['required', 'integer'],
            'content' => ['required', 'array']
        ];
    }
}