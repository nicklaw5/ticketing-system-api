<?php

/**
 * Gets the path to the Stryve folder
 * 
 * @return string
 */
function stryve_path()
{
	return app_path().'/Stryve';
}

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