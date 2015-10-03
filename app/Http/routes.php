<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['domain' => '{organization}.stryve.io'], function()
{
	Route::group(['prefix' => 'api/v1', 'middleware' => ['api.before', 'api.after' ] ], function()
	{	
		// Route::resource('auth', 'AuthController');
		Route::resource('users', 'UsersController');
		// Route::resource('tickets', 'TicketsController');
		// Route::resournce('subscriptions', 'SubscriptionsController');
	});
});