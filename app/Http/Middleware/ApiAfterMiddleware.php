<?php

namespace App\Http\Middleware;

use Closure;

class ApiAfterMiddleware
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
        $response = $next($request);

        // Perform after action here

        // calculate request execution time
        // echo number_format((microtime(true) - ($request->session()->pull('start', 'default'))), 2);

        return $response;
    }
}
