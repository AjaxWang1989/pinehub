<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Http\Response\Factory;
use Illuminate\Support\Facades\Log;

class Cross
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next = null)
    {
        if ($request->method() === HTTP_METHOD_OPTIONS) {
            exit;
            $response = app(Factory::class)->created();
            return $this->setHeader($response, $request);
        }
        $response = $next($request);
        $this->setHeader($response, $request);
        return $response;
    }

    private function setHeader(&$response, $request)
    {
        $origin = $request->header('ORIGIN', '*');
        if (method_exists($response, 'header')) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept, Authorization, ProjectId, project_id');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
            return $response;
        } else {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Headers: Origin, Content-Type, Cookie, Accept, Authorization, ProjectId, project_id');
            header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Credentials: true');
            return $response;
        }

    }
}
