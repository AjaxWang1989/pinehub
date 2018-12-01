<?php

namespace App\Entities;

use App\Entities\Traits\ModelAttributesAccess;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\File
 *
 * @property int $id
 * @property string $endpoint 云存储节点url，本地存储root
 * @property string|null $bucket 云存储bucket或者本地存储路径
 * @property string $driver 文件存储驱动
 * @property string $path 文件路径
 * @property string|null $extension 文件拓展名
 * @property string|null $mimeType 文件类型
 * @property string|null $name 文件名
 * @property string|null $src 文件url路径
 * @property int $encrypt 是否加密
 * @property string|null $encryptKey 密钥
 * @property string|null $encryptMethod 加密算法
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereBucket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncryptKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEncryptMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class File extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'endpoint',
        'driver',
        'bucket',
        'path',
        'src',
        'name',
        'type',
        'extension',
        'encrypt',
        'encrypt_key',
        'encrypt_method'
    ];

}
