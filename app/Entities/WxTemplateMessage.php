<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use App\Services\AppManager;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WxTemplateMessage.
 *
 * 微信模板库
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $templateId 模版消息id
 * @property string $wxAppId 微信 app id
 * @property string $title 模板标题
 * @property string $primaryIndustry 模板所属行业的一级行业
 * @property string $deputyIndustry 模板所属行业的二级行业
 * @property string $content 消息模版内容
 * @property string $example 模板消息示例
 * @property array $items 模板消息关键字中文
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereDeputyIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage wherePrimaryIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WxTemplateMessage whereWxAppId($value)
 * @mixin Eloquent
 */
class WxTemplateMessage extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['template_id', 'wx_app_id', 'title', 'primary_industry', 'deputy_industry', 'content', 'items'];

    protected $casts = [
        'items' => 'array'
    ];

}
