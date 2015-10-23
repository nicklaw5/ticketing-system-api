<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpNotFoundExeption extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'resource not found', $code = 0)
    {
        parent::__construct($msg, $code);
    }
}