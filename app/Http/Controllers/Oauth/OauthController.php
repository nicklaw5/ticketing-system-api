<?php

namespace App\Http\Controllers\Oauth;

use Authorizer;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OauthController extends Controller
{		

	/**
	 * Respond to the incoming auth code requests. Displays a form 
	 * where the user can authorize the client to access it's data
	 * 
	 * @return \Illuminate\Http\Response
	 */
	// http://company.stryve.io:8000/api/oauth/authorize?client_id=test&redirect_uri=http://company.stryve.io:8000/api/v1/users&response_type=code
   	public function getAuthorize()
   	{
   		$authParams = Authorizer::getAuthCodeRequestParams();
   		$formParams = array_except($authParams,'client');
   		$formParams['client_id'] = $authParams['client']->getId();
   		
   		return view('private.oauth.authorization-form', [
   			'params' => $formParams,
   			'client'=>$authParams['client']
   		]);
	}

	/**
	 * Respond to the form being posted.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postAuthorize()
	{
		// dd('here');
		$params = Authorizer::getAuthCodeRequestParams();

		// dd($params);
	    $params['user_id'] = Auth::user()->id;
	    $redirectUri = '';

	    // if the user has allowed the client to access its data, redirect back to the client with an auth code
	    if (request('approve') !== null) {
	        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
	    }

	    // if the user has denied the client to access its data, redirect back to the client with an error message
	    if (request('deny') !== null) {
	        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
	    }

	    // dd($redirectUri);

	    return redirect($redirectUri);
	}

	// /**
	//  * Respond to the access token requests.
	//  *
	//  * @return json
	//  */
	// public function postAccessToken()
	// {

	// 	// curl url 		=> http://company.stryve.io:8000/api/oauth/access_token
	// 	// grant_type 		=> authorization_code
	// 	// client_id 		=> test
	// 	// client_secret 	=> test
	// 	// redirect_uri		=> http://company.stryve.io:8000/api/v1/users
	// 	// code 			=> uhLG7rQOHCxliJ4ayKlVuqdVW1mU70MxB31JEKV0

	// 	return response()->json(Authorizer::issueAccessToken());
	// }

	/**
	 * Respond to the access token requests.
	 *
	 * @return json
	 */
	public function requestAccessToken()
	{
		/* REQUEST */
		// cURL/POST url 	=> http://api.stryve.io:8000/oauth/access_token
		// grant_type 		=> client_credentials
		// client_id 		=> 1
		// client_secret 	=> test_secret_1
		return response()->json(Authorizer::issueAccessToken());

		/* JSON REQUEST */
		// {
		// 	"access_token": "SEwGZDGeBKqNVmVeaYaeX7wMea6EhH913UnYCLee",
		//   	"token_type": "Bearer",
		//   	"expires_in": 3600
		// }
	}
}

