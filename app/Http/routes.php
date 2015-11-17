<?php

// api subdomain endpoint for administration
Route::group(['domain' => 'api.stryve.io',], function()
{
	Route::group(['prefix' => 'v1'], function()
	{
		// OAUTH ROUTES
		Route::group(['prefix' => 'oauth', 'namespace' => 'Oauth', 'as' => 'oauth::'], function()
		{	
			// Route::get('authorize', ['middleware' => ['check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@getAuthorize']);
			// Route::post('authorize', ['middleware' => ['csrf', 'check-authorization-params'/*, 'auth'*/], 'uses' => 'OauthController@postAuthorize']);
			Route::post('access-token', ['as' => 'access-token', 'uses' => 'OauthController@requestAccessToken']);

			// Route::post('refresh-token', 'OauthController@requestRefreshToken');

			// From Lumen Example
			// Route::post('access-token', ['as' => 'access-token', 'uses' => 'OauthController@requestAccessToken']);
	     	// Route::post('refresh-token', ['as' => 'refresh-token', 'uses' => 'OauthController@requestRefreshToken']);
		});

		// REGISTER ROUTE
		Route::group(['prefix' => 'accounts', 'as' => 'accounts::', 'middleware' => 'oauth'], function()
		{
			Route::post('register', ['as' => 'register', 'uses' => 'AccountsController@store']);
		});
	});
});

// SUBSCRIBER API ENDPOINTS
Route::group(['domain' => '{account}.stryve.io', 'middleware' => 'acc.exists'], function()
{
	// AUTHENTICATION ROUTES
	Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'as' => 'auth::'], function()
	{
		// Route::get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
		// Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
		// Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword']);
	});

	

	// API ENDPOINTS
	Route::group(['prefix' => 'api'], function()
	{
		// V1 ENDPOINTS
		Route::group(['prefix' => 'v1', 'middleware' => ['oauth', 'api.before', 'api.after' ] ], function()
		{
			Route::resource('users', 'UsersController');
			Route::resource('tickets', 'TicketsController');
			Route::resource('accounts', 'AccountsController');
		});
	});

	// // tenant end-points
	// Route::group(['prefix' => 'v1/{tenant}', 'namespace' => '', 'middleware' => ['oauth', 'api.before', 'api.after' ] ], function()
	// {
		
	// });

	// // admin end-points
	// Route::group(['prefix' => 'v1/admin', 'namespace' => 'Admin', 'middleware' => ['oauth', 'api.before', 'api.after' ] ], function()
	// {
	// 	Route::get('/', function()
	// 	{
	// 		// echo \LucaDegasperi\OAuth2Server\Facades\Authorizer::getResourceOwnerId();
			
	// 		dd(\Uuid::generate()->string);
	// 	});

	// 	Route::resource('staff', 'StaffController');
	// 	Route::resource('tenants', 'TenantsController');
	// 	Route::resource('organizations', 'OrganizationsController');
	// });

});