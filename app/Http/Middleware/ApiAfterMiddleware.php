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

        echo ' after ';

        return $response;
    }
}
