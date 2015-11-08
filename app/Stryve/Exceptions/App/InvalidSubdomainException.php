<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class InvalidSubdomainException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Invalid subdomain.', $code = 4002)
    {
        parent::__construct($msg, $code);
    }
}