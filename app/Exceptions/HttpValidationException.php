<?php

namespace App\Exceptions;

use Dingo\Api\Exception\ValidationHttpException as Exception;

class HttpValidationException extends Exception
{
    //
    public function __construct($errors = null, int $code = 0, \Exception $previous = null, array $headers = [])
    {
        parent::__construct($errors, $previous, $headers, $code);

        $this->message = 'Invalid params';
    }
}
