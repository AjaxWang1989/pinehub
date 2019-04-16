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
    private $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}