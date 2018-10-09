<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
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
            'detail' => ['required'],
            'origin_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'cost_price' => ['numeric'],
            'factory_price' => ['numeric'],
            'stock_num' => ['required', 'integer'],
            'status' => ['required', 'in:'.Merchandise::UP.','.Merchandise::DOWN]
        ];
    }
}
