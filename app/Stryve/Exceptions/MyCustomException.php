<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class MyCustomException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public $httpStatusCode = 123;

    /**
     * {@inheritdoc}
     */
    public $httpStatus = 'custom_status';

    public function __construct($msg = 'my custom message')
    {
        parent::__construct($msg);
    }
}