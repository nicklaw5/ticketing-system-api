<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
	/**
	 * index method
	 * 
	 * @param none 
	 * @return void 
	 */
	public function index(Request $request, $tenant)
	{
		// dd($request->headers->all());
	}
}
