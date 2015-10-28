<?php

namespace Stryve\Exceptions;

use Stryve\Exceptions\StryveException;

class FailedTenantMigrationException extends StryveException
{
	/**
     * {@inheritdoc}
     */
    public function __construct($msg = 'Failed to run tenant migration.', $code = 5001)
    {
        parent::__construct($msg, $code);
    }
}