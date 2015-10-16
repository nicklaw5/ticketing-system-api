<?php

// Global API - access restriction are based on the passed token (and associated scopes) in the header
// If request come from a known IP address that is behind the 
Route::group(['domain' => 'api.stryve.io'/*, 'middleware' => 'auth'*/], function()
{
	Route::get('oauth/authorize', ['middleware' => ['check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@getAuthorize']);
	Route::post('oauth/authorize', ['middleware' => ['csrf', 'check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@postAuthorize']);
	Route::post('oauth/access_token', 'OauthController@postAccessToken');

	Route::group(['prefix' => 'v1', 'middleware' => ['api.before', 'api.after' ] ], function()
	{
		// subscriber end-points
		Route::group(['prefix' => '{organization}', 'middleware' => 'org.auth'], function()
		{
			Route::resource('auth', 'AuthController');
			Route::resource('users', 'UsersController');
			Route::resource('billing', 'BillingController');
			Route::resource('tickets', 'TicketsController');
			Route::resource('profile', 'ProfileController');
			Route::resource('dashboard', 'DashboardController');
			Route::resournce('subscriptions', 'SubscriptionsController');
			Route::resource('ticket-attachments', 'TicketAttachmentsController');
		});

		// admin end-points
		Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function()
		{
			Route::resource('staff', 'StaffController');
			Route::resource('organizations', 'OrganizationsController');
		});
	});
});