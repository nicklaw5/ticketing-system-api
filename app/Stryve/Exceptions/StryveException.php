<?php

namespace Stryve\Exceptions;

/**
 * Exception class
 */
class StryveException extends \Exception
{
	/**
     * Throw a new exception
     *
     * @param string $msg Exception Message
     */
    public function __construct($msg = '')
    {
    	$msg = ($msg == '')? 'error' : 'error: ' . $msg; 
        parent::__construct($msg);
    } 
}
