<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\File;

/**
 * Class FileTransformerTransformer.
 *
 * @package namespace App\Transformers;
 */
class FileTransformer extends TransformerAbstract
{
    /**
     * Transform the FileTransformer entity.
     *
     * @param \App\Entities\File $model
     *
     * @return array
     */
    public function transform(File $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'driver'     => $model->driver,
            'src'        => $model->src,
            'bucket'     => $model->bucket,
            'encrypt'    => $model->encrypt,
            'encrypt_key'=> $model->encryptKey,
            'encrypt_method' => $model->encryptMethod,
            'endpoint'   => $model->endpoint,
            'path'       => $model->path,
            'type'       => $model->type,
            'extension'  => $model->extension,
            /* place your other model properties here */
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }
}
