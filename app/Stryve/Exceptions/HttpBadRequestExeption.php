<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class HttpBadRequestExeption extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'An unknown error occured')
    {
        parent::__construct($msg);
    }
}