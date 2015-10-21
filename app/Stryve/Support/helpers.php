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