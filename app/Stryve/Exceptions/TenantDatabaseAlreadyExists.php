<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class TenantDatabaseAlreadyExists extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Unable to create database.', $code = 4001)
    {
        parent::__construct($msg, $code);
    }
}