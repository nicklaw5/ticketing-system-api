<?php

namespace Stryve\Exceptions;

class StryveException extends \Exception
{
	/**
     * Throw a new Styve Exception
     *
     * @param string $msg
     * @param int $code
     */
    public function __construct($msg = 'An unknown error occured', $code  = 0)
    {
        parent::__construct($msg, $code);
    } 
}
