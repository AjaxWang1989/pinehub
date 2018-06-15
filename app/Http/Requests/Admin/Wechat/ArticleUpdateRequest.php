<?php

namespace App\Http\Requests\Admin\Wechat;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'index' => ['integer'],
            'article' => ['required', 'json'],
            'article.title' => ['required', 'string'],
            'article.thumb_media_id' => ['required', 'string'],
            'article.author' => ['string'],
            'article.digest' => ['string'],
            'article.show_cover_pic' => ['required', 'boolean'],
            'article.content' => ['required', 'string', 'max:20000'],
            'article.content_source_url' => ['required', 'string'],
            'article.need_open_comment' => ['required', 'boolean'],
            'article.only_fans_can_comment' => ['required', 'boolean']
        ];
    }
}
