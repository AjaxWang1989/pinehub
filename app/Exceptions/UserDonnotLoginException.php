<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as  Exception;

class UserDonnotLoginException extends Exception
{
    //
    public function __construct(int $code, string $message = null, \Exception $previous = null, array $headers = array())
    {
        parent::__construct(HTTP_STATUS_UNAUTHORIZED, $message, $previous, $headers, $code);
    }
}
