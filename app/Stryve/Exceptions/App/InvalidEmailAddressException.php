<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class InvalidEmailAddressException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Invalid email address.', $code = 4003)
    {
        parent::__construct($msg, $code);
    }
}