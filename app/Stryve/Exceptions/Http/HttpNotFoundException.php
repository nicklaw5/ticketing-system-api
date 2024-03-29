<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpNotFoundException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Not Found', $code = 404)
    {
        parent::__construct($msg, $code);
    }
}