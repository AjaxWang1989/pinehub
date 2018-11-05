<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class TicketSyncException extends Exception
{
    //
    public function __construct(int $code, string $message = null, \Exception $previous = null, array $headers = array()) {
        parent::__construct(HTTP_STATUS_INTERNAL_SERVER_ERROR, $message, $previous, $headers, $code);
    }
}
