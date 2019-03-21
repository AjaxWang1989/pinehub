<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnifyOrderException extends HttpException
{
    //
    public function __construct(string $message = null, int $code = PAYMENT_UNIFY_ERROR, \Exception $previous = null, array $headers = array())
    {
        parent::__construct(HTTP_STATUS_INTERNAL_SERVER_ERROR, $message, $previous, $headers, $code);
    }
}
