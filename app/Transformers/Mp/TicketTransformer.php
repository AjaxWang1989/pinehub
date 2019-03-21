<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/12/5
 * Time: 9:37 PM
 */

namespace App\Transformers\Mp;


use App\Entities\Card;
use League\Fractal\TransformerAbstract;

class TicketTransformer extends TransformerAbstract
{
    public function transform(Card $card)
    {
        return [
            'id' => $card->id,
            'card_id' => $card->cardId,
            'type' => $card->cardType,
            'info' => $card->cardInfo
        ];
    }
}