<?php

namespace App\Http\Requests\Admin;

use App\Entities\Merchandise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchandiseCreateRequest extends FormRequest
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
            'cost_price' => ['numeric'],
            'factory_price' => ['numeric'],
            'stock_num' => ['required', 'integer'],
            'status' => ['required', Rule::in([Merchandise::UP,Merchandise::DOWN])]
        ];
    }
}
