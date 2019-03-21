<?php

namespace App\Http\Requests\Admin\Wechat;

use Dingo\Api\Http\FormRequest;

class ArticleCreateRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'introduction' => ['required', 'string'],
            'thumb_media_id' => ['required', 'string'],
            'author' => ['string'],
            'digest' => ['string'],
            'show_cover' => ['required', 'boolean'],
            'content' => ['required', 'string', 'max:20000'],
            'content_source_url' => ['required', 'string'],
            'need_open_comment' => ['required', 'boolean'],
            'only_fans_can_comment' => ['required', 'boolean']
        ];
    }
}
