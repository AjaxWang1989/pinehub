<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-19
 * Time: 下午5:31
 */

namespace App\Http\Requests\Admin;

use Dingo\Api\Http\FormRequest;

class AdvertisementUpdateRequest extends FormRequest
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

        ];
    }
}