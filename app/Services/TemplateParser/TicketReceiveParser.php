<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午4:47
 */

namespace App\Services\TemplateParser;

use App\Entities\Ticket;

class TicketReceiveParser extends BaseParser
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function title()
    {
        return $this->ticket->cardInfo['base_info']['title'];
    }

    public function cardCode()
    {
        return $this->ticket->code;
    }

    public function validateTime()
    {
        return $this->ticket->beginAt . '至' . $this->ticket->endAt;
    }
}