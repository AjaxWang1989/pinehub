<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class TokenOverDateException extends Exception
{
    //
    public function __construct( string $message = null, ?int $code = 0, $statusCode= HTTP_STATUS_UNAUTHORIZED, \Exception $previous = null, array $headers = array())
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
