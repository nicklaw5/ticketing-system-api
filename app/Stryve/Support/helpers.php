<?php

// /**
//  * Sets new database connection
//  * 
//  * @param string $connection_name
//  * @param array $options
//  * @return void
//  */
// function setDatabaseConnetion($connection_name, $options = [])
// {
// 	// Will contain the array of connections that appear in our database config file.
//     $connections = \Config::get('database.connections');

//     // This line pulls out the default connection by key (by default it's `mysql`)
//     $default = \Config::get('database.default');
//     $defaultOptions = $connections[$default];

//     // Now we simply copy the default connection information to our new connection.
//     $newOptions = $defaultOptions;

//     // Override the database name.
//     foreach($newOptions as $item => $value)
//         $newOptions[$item] = isset($options[$item]) ? $options[$item] : $newOptions[$item];

//     // This will add our new connection to the run-time configuration for the duration of the request.
//     \Config::set('database.connections.'.$connection_name, $newOptions);
// }

// /**
//  * Reset default database connection
//  * 
//  * @return array
//  */
// function getDefaultDatabaseConnetion()
// {
// 	$connection = \Config::get('database.default');
//     $options = \Config::get('database.connections.' . $connection);

//  	return [
//  		'connection' => $connection,
//  		'options'	 => $options
//  	];
// }

/*******************/
/* STRYVE SPECIFIC */
/*******************/

/**
 * Gets the path to the Stryve folder
 * 
 * @return string
 */
function stryve_path()
{
	return app_path().'/Stryve';
}

/**********/
/* SERVER */
/**********/

/**
 * Attempts to get the client's locale
 *
 * @return mixed
 */
function getClientLocale()
{
	// can return 'en-GB', 'en-US', etc., or null if undetermined
	$locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);

	if($locale)
		return $locale;

	return null;
}

/**************************/
/* DOMAINS AND SUBDOMAINS */
/**************************/

/**
 * Determines whether or not the provided string
 * meets subdomain character requirements.
 * 
 * @param string $string
 * @return bool
 */
function isValidSubdomain($string)
{
	// The regular expression for allowable characters in a	subdomain: a-Z, 0-9, and hypens (no hypens at start or end)
	$pattern = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]))*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/i';

	if(1 !== preg_match($pattern, $string))
		return false;

	return true;
}

/**
 * Returns a subdomain
 * 
 * @return string 
 */
function getSubdomainFromHttpHost()
{
	return  array_shift((explode(".", $_SERVER['HTTP_HOST'])));
}

/**********************/
/* ARRAYS AND OBJECTS */
/**********************/

/**
 * Converts an array to StdClass Object
 * 
 * @param array $array
 * @return StdClass Object
 */
function arrayToStdClassObject(array $array)
{
	return json_decode(json_encode($array));
}

/*********/
/* EMAIL */
/*********/

/**
 * Tests that a given email address is valid
 * 
 * @param string $emailAddress
 * @return bool
 */
function isValidEmailAddress($emailAddress)
{
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		return false;

	return true;
}

/***********/
/* STRINGS */
/***********/

/**
 * Converts a string to NULL if empty
 * 
 * @param string
 * @return mixed
 */
function emptyStringToNull($string)
{
	$string = (string) trim($string);
	
	if($string === '')
		return null;

	return $string;
}

/**
 * Converts and returns a string after being
 * trimmed and lowered.
 * 
 * @param string $string
 * @return string
 */
function lowertrim($string)
{
	return strtolower(trim($string));
}

/**
 * Converts and returns a string after being
 * trimmed and uppered.
 * 
 * @param string $string
 * @return string
 */
function uppertrim($string)
{
	return strtoupper(trim($string));
}

/**
 * Replace all occurances of hyphens (-)
 * with the replacement param.
 * 
 * @param string $string
 * @param string $replacement
 * @return void 
 */
function replaceHyphens($string, $replacement)
{
	return preg_replace('/[\-]/', $replacement, $string);
}

/**
 * Generates a random string with the provided length
 * 
 * @param int $length
 * @return string
 */
function generateRandomString($length = 12, $numbers = true, $lowercase = true, $uppercase = true, $specials = true)
{
	$number_chars   = '0123456789';
	$lower_chars 	= 'abcdefghijklmnopqrstuvwxyz';
	$upper_chars 	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$special_chars	= '!@#$%&*?';
	
	$characters  = ($numbers)? $number_chars : '';
	$characters .= ($lowercase)? $lower_chars : '';
	$characters .= ($uppercase)? $upper_chars : '';
	$characters .= ($specials)? $special_chars : '';

	return substr(str_shuffle($characters), 0, $length);
}