<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpUnauthorizedException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Forbidden', $code = 401)
    {
        parent::__construct($msg, $code);
    }
}