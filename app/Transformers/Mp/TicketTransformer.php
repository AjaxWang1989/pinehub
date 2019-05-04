<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/12/5
 * Time: 9:37 PM
 */

namespace App\Transformers\Mp;


use App\Entities\Card;
use App\Entities\Ticket;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class TicketTransformer extends TransformerAbstract
{
    public function transform(Ticket $card)
    {
        Log::debug('customer tickets', [$card->customerTickets->count(), $card->cardInfo['base_info']['get_limit']]);
        return [
            'id' => $card->id,
            'card_id' => $card->cardId,
            'type' => $card->cardType,
            'info' => $card->cardInfo,
            'can_get' => $card->customerTickets->count() < $card->cardInfo['base_info']['get_limit']
        ];
    }
}