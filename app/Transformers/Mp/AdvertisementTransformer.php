<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-3-20
 * Time: 下午7:46
 */

namespace App\Transformers\Mp;

use App\Entities\Advertisement;
use App\Entities\Ticket;
use League\Fractal\TransformerAbstract;

class AdvertisementTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['ticket'];

    public function transform(Advertisement $model)
    {
        return [
            'id' => (int)$model->id,
            'title' => (string)$model->title,
            'banner_url' => (string)$model->bannerUrl,
//            'ticket' => $model->ticket,
            'begin_at' => (string)$model->beginAt,
            'end_at' => (string)$model->endAt,
        ];
    }

    public function includeTicket(Advertisement $advertisement)
    {
        $ticket = $advertisement->ticket;

        if (is_null($ticket)) {
            return null;
        }

        return $this->item($ticket, (new TicketTransformer()));
    }
}