<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShopCreateRequest extends FormRequest
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
            'name'           => [ 'string', 'size:32'],
            'user_id'        => ['integer', 'exist:user,id'],
            'description'    => ['string'],
            'country_id'     => ['required', 'integer', 'exist:country,id'],
            'province_id'    => ['required', 'integer', 'exist:province,id'],
            'city_id'        => ['required', 'integer', 'exist:city,id'],
            'county_id'      => ['required', 'integer', 'exist:county,id'],
            'address'        => ['required', 'string'],
            'lng'            => ['required', 'numeric'],
            'lat'            => ['require', 'numeric'],
            'manager_mobile' => ['regex:'.MOBILE_PATTERN, 'not_exists:user,mobile'],
            'manager_name'   => ['string', 'max:16'],
            'status'         => ['integer', 'in:0,1,2,3']
        ];
    }
}
