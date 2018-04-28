<?php

namespace App\Http\Controllers;

use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use Helpers;

    protected function response($data = null)
    {
        return $data ? $this->response->created()->setContent($data) : app(Response\Factory::class);
    }
}
