<?php

namespace Stryve\Exceptions\Http;

use Stryve\Exceptions\StryveException;

class HttpBadRequestException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Bad Request', $code = 400)
    {
        parent::__construct($msg, $code);
    }
}