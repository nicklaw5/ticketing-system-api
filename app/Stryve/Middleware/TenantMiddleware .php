<?php

namespace App\Stryve\Middleware;

use Closure;

class TenantMiddleware
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
        // Add tenant id to request

        // Add tenant locale and timezone to request

        // Add tenant IP address to request

        // print_r($request->header('accept'));
        return $next($request);
    }
}
