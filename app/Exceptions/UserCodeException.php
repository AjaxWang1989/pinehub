<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 15:07
 */

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;


class UserCodeException extends HttpException
{
    public function __construct(string $message = null, int $code = USER_CODE_ERROR, \Exception $previous = null, array $headers = array())
    {
        parent::__construct(HTTP_STATUS_INTERNAL_SERVER_ERROR, $message, $previous, $headers, $code);
    }
}