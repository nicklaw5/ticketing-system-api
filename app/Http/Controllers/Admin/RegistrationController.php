<?php

namespace app\Http\Controllers\Admin;

use App\Tenant;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
	/**
	 * @var \App\Tenant
	 */
	protected $tenant;

 	/**
 	 * Instantiate a new instance
 	 * 
 	 * @param \App\Tenant
 	 * @return void
 	 */
 	public function __construct(Tenant $tenant)
 	{
 		$this->tenant = $tenant;
 	}

	/**
     * Attempt 
     */
    public function store()
    {
    	//
    }
}