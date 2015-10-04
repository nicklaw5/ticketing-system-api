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

Route::group(['domain' => '{organization}.stryve.io'/*, 'middleware' => 'auth'*/], function()
{
	/***************/
	/* INDEX ROUTE */
	/***************/
	Route::get('/', 'AuthController@index');

	/********************/
	/* DASHBOARD ROUTES */
	/********************/
	Route::get('/dashboard', 'DashboardController@index');

	/***************/
	/* AUTH ROUTES */
	/***************/
	Route::get('auth/login', 'AuthController@getlogin');
	// Route::get('auth/logout', 'AuthController@logout');
	// Route::get('auth/forgot-password', 'AuthController@forgotPassword');

	/****************/
	/* OTHER ROUTES */
	/****************/
	// Route::resource('users', 'UsersController');
	// Route::resource('tickets', 'TicketsController');
	// Route::resournce('subscriptions', 'SubscriptionsController');

	// /api/...
	Route::group(['prefix' => 'api'], function()
	{
		// /api/oauth/...
		Route::get('oauth/authorize', ['middleware' => ['check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@getAuthorize']);
		Route::post('oauth/authorize', ['middleware' => ['csrf', 'check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@postAuthorize']);
		Route::post('oauth/access_token', 'OauthController@postAccessToken');
		
		// /api/v1/...
		Route::group(['prefix' => 'v1', 'middleware' => ['api.before', 'api.after' ] ], function()
		{	
			// Route::resource('users', 'UsersController');
			// Route::resource('tickets', 'TicketsController');
			// Route::resournce('subscriptions', 'SubscriptionsController');
		});

	});

});