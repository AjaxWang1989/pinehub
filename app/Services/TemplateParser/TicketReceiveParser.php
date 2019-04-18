<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午4:47
 */

namespace App\Services\TemplateParser;

use App\Entities\Ticket;
use Illuminate\Support\Facades\Log;

class TicketReceiveParser extends BaseParser
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function title()
    {
        Log::info('转化优惠券title：', [$this->ticket->cardInfo['base_info']['title']]);
        return $this->ticket->cardInfo['base_info']['title'];
    }

    public function cardCode()
    {
        return $this->ticket->code;
    }

    public function validateTime()
    {
        Log::info('转化优惠券有效期：', [$this->ticket->beginAt . '至' . $this->ticket->endAt]);
        return $this->ticket->beginAt . '至' . $this->ticket->endAt;
    }
}