<?php

namespace App\Http\Middleware;

use Closure;

class Ticket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $type
     * @return mixed
     */
    public function handle($request, Closure $next, string $type = null)
    {
        $data = $request->all();
        $data['ticket_type'] = $type;
        $_REQUEST['ticket_type'] = $data['ticket_type'];
        $request->merge($data);
        return $next($request);
    }
}
