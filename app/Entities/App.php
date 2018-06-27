<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class App.
 *
 * @package namespace App\Entities;
 */
class App extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function officialAccount(): BelongsTo
    {
        $this->belongsTo(WechatConfig::class, 'wechat_app_id', 'app_id')->where('type', WECHAT_OFFICIAL_ACCOUNT);
    }

    public function miniProgram(): BelongsTo
    {
        $this->belongsTo(WechatConfig::class, 'wechat_app_id', 'app_id')->where('type', WECHAT_MINI_PROGRAMg);
    }

}
