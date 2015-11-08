<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class TenantAlreadyExistsException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Tenant already exists.', $code = 4001)
    {
        parent::__construct($msg, $code);
    }
}