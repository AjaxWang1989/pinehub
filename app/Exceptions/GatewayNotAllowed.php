<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/5
 * Time: 下午2:20
 */

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class GatewayNotAllowed extends HttpException
{

    const GATEWAY_NOT_ALLOWED = 'GATEWAY_NOT_ALLOWED';
    public function __construct(string $message = null, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        parent::__construct(HTTP_STATUS_UNAVAILABLE_FOR_LEGAL_REASONS, $message, $previous, $headers);
        $this->code = self::GATEWAY_NOT_ALLOWED;
    }
}