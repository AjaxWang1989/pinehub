<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/6
 * Time: 下午12:43
 */

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class MenuSyncFail extends HttpException
{
    const CODE = 'MENU_SYNC_FAIL';
    public function __construct(string $message = null, \Exception $previous = null, array $headers = array())
    {
        parent::__construct(HTTP_STATUS_INSUFFICIENT_STORAGE, $message, $previous, $headers, self::CODE);
    }
}