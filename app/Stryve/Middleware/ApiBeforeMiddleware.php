<?php

namespace Stryve\Middleware;

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
        // Check ip is not blacklisted - flatfile fallback (ideally this should be done at the load balancer)


        /** Perform before action here **/
        // - Is the account active/inactive?
        // - Has the account subscription lasped?
        
        
        /** AUTH CODE GRANT ONLY **/
        // - Do the auth credentials match a user from that orginization
        // - Do the auth credentials authenticate with the server
        // - Does the user scope allow for the requested action


        // Set request start time
        // $request->session()->flash('start', microtime(true));
        
        // print_r($request->header('accept'));
        return $next($request);
    }
}
