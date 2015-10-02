<?php

namespace App\Http\Middleware;

use Closure;

class ApiBeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Perform before action here

            // Check ip is not blacklisted - flatfile fallback (ideally this should be done at the load balancer)
            // 

        echo 'before ';
        // print_r($request->header('accept'));
        return $next($request);
    }
}
