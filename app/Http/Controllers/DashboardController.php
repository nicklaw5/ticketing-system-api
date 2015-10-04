<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Dislplay the dashboard view
     */
    public function index()
    {
    	return view('private.dashboard.index', [
    		'title' => 'Dashboard'
    	]);
    }
}