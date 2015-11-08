<?php

namespace Stryve\Middleware;

use Closure;
use App\Models\Account;


class AccountExistsMiddleware
{
	/**
	 * @var \App\Models\Account
	 */
	protected $account;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(Account $account)
	{
		$this->account = $account;
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	// gte the requested subdomain
        $subdomain = getSubdomainFromHttpHost();

        // check that the account exists.
        if($this->account->exists($subdomain))
        {
            // add the account's subdomain to the request
            $request->account = $subdomain;

            // contimue on
            return $next($request);
        }
        else
        {
            // if it dosn't throw 404 error
            throw new HttpNotFoundException(); 
        }

    }
}
