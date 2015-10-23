<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpBadRequestExeption extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'A bad request occured.', $code = 4001)
    {
        parent::__construct($msg, $code);
    }
}