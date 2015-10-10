<?php

// Global API - access restriction are based on the passed token (and associated scopes) in the header
Route::group(['domain' => 'api.stryve.io'/*, 'middleware' => 'auth'*/], function()
{
	Route::get('oauth/authorize', ['middleware' => ['check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@getAuthorize']);
	Route::post('oauth/authorize', ['middleware' => ['csrf', 'check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@postAuthorize']);
	Route::post('oauth/access_token', 'OauthController@postAccessToken');

	Route::group(['prefix' => 'v1', 'middleware' => ['api.before', 'api.after' ] ], function()
	{
		// public end-points
		Route::resource('users', 'UsersController');
		Route::resource('profile', 'ProfileController');
		Route::resource('tickets', 'TicketsController');
		Route::resource('ticket-attachments', 'TicketAttachmentsController');
		Route::resournce('subscriptions', 'SubscriptionsController');

		// private end-points
		Route::resource('users')
	});
});

// Backend API for Organization Administration
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