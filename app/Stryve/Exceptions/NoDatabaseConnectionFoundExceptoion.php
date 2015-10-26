<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class NoDatabaseConnectionFoundExceptoion extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Database connection not found.', $code = 4041)
    {
        parent::__construct($msg, $code);
    }
}