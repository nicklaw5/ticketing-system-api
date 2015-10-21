<?php

namespace Stryve\Exceptions;

use Stryve\Util\RedirectUri;
use Symfony\Component\HttpFoundation\Request;

/**
 * Exception class
 */
class StryveException extends \Exception
{
    /**
     * The HTTP status code for this exception that should be sent in the response
     * 
     * @var int
     */
    public $httpStatusCode = 400;

    /**
     * The HTTP status
     * 
     * @var string
     */
    public $httpStatus = 'error';

    /**
     * Throw a new exception
     *
     * @param string $msg Exception Message
     */
    public function __construct($msg = 'An error occured')
    {
        parent::__construct($msg);
    }

    /**
     * Gets the HTTP status code
     * 
     * @return int 
     */
    public function getHttpStatusCode()
    {
    	return $this->httpStatusCode;
    }

    /**
     * Gets the HTTP status
     * 
     * @return string
     */
    public function getHttpStatus()
    {
    	return $this->httpStatus;
    }
}
