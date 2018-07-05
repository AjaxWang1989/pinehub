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

        if($type === null) {
            $data['card_type'] = $data['ticket_type'];
            unset($data['ticket_type']);
        }else{
            $data['ticket_type'] = $type;
        }
        $request = $request->request->replace($data);
        return $next($request);
    }
}
