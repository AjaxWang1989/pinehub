<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-4
 * Time: 上午11:26
 */

namespace App\Http\Requests\Admin\Wechat;

use Dingo\Api\Http\FormRequest;

class UserTemplateMessageUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

}