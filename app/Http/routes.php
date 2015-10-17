<?php

// Global API - access restriction are based on the passed token (and associated scopes) in the header
// If request come from a known IP address that is behind the 
Route::group(['domain' => 'api.stryve.io'], function()
{
	// oauth end-points
	Route::group(['prefix' => 'oauth', 'namespace' => 'Oauth'], function()
	{
		// Route::get('authorize', ['middleware' => ['check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@getAuthorize']);
		// Route::post('authorize', ['middleware' => ['csrf', 'check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@postAuthorize']);
		Route::post('access-token', 'OauthController@postAccessToken');
	});

	// tenant end-points
	Route::group(['prefix' => 'v1/{tenant}', 'namespace' => 'Tenant', 'middleware' => ['oauth', 'api.before', 'api.after' ] ], function()
	{
		// Route::resource('auth', 'AuthController');
		// Route::resource('users', 'UsersController');
		// Route::resource('billing', 'BillingController');
		Route::resource('tickets', 'TicketsController');
		// Route::resource('profile', 'ProfileController');
		// Route::resource('dashboard', 'DashboardController');
		// Route::resournce('subscriptions', 'SubscriptionsController');
		// Route::resource('ticket-attachments', 'TicketAttachmentsController');
	});

	// admin end-points
	Route::group(['prefix' => 'v1/admin', 'namespace' => 'Admin', 'middleware' => ['oauth', 'api.before', 'api.after' ] ], function()
	{
		Route::get('/', function()
		{
			// echo \LucaDegasperi\OAuth2Server\Facades\Authorizer::getResourceOwnerId();
			
			dd(\Uuid::generate()->string);
		});

		Route::resource('staff', 'StaffController');
		Route::resource('tenants', 'TenantsController');
		Route::resource('organizations', 'OrganizationsController');
	});

});