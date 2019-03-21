<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleNotAllowed extends HttpException
{
    const ROLE_NOT_ALLOWED = 'ROLE_NOT_ALLOWED';
    public function __construct(int $statusCode, string $message = null, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, self::ROLE_NOT_ALLOWED);
    }
}
