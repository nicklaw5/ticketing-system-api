<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpConflictException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Conflict', $code = 409)
    {
        parent::__construct($msg, $code);
    }
}