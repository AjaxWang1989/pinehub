<?php

namespace App\Http\Requests\Admin;

use Dingo\Api\Http\FormRequest;
use App\Entities\Merchandise;

class MerchandiseUpdateRequest extends FormRequest
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
            'categories' => ['required', 'array'],
            'name' => ['required', 'max:255'],
            'main_image' => ['required', 'url'],
            'images' => ['required', 'array'],
            'preview' => ['required', 'max:256'],
            'origin_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'cost_price' => ['nullable', 'numeric'],
            'factory_price' => ['nullable', 'numeric'],
            'stock_num' => ['required', 'integer'],
            'status' => ['required', 'in:'.Merchandise::UP.','.Merchandise::DOWN]
        ];
    }
}
