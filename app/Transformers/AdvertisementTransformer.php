<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Advertisement;

/**
 * Class AdvertisementTransformer.
 *
 * @package namespace App\Transformers;
 */
class AdvertisementTransformer extends TransformerAbstract
{
    /**
     * Transform the Advertisement entity.
     *
     * @param \App\Entities\Advertisement $model
     *
     * @return array
     */
    public function transform(Advertisement $model)
    {
        $ticket = $model->ticket;

        if ($ticket) {
            $ticket = (new TicketItemTransformer())->transform($model->ticket);
        }

        return [
            'id' => (int)$model->id,

            /* place your other model properties here */
            'title' => (string)$model->title,
            'banner_url' => (string)$model->bannerUrl,
            'ticket' => $ticket,
            'conditions' => $model->conditions,
            'begin_at' => (string)$model->beginAt,
            'end_at' => (string)$model->endAt,
            'status' => $model->status,
            'status_desc' => $model->statusDesc,

            'created_at' => (string)$model->created_at,
            'updated_at' => (string)$model->updated_at
        ];
    }
}
