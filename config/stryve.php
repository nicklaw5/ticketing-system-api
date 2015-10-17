<?php

return [
	
	/**
	 * Various default/central configurations for tenants
	 */
	'tentant' => [

		'subdomain' => [

			// The maximum allowable length for a tenant's subdomain
			'length' => 40,

			// The regular expression for allowable characters in a
			// subdomain: a-Z, 0-9, and hypens (no hypens at start or end)
			'regex' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]))*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/ig'
		],
	],
	/*
    |--------------------------------------------------------------------------
    | State Parameter
    |--------------------------------------------------------------------------
    | 
    | a-z
	| 0-9
	| - but not as a starting or ending character
    |
    */
	'tenant-name-regex' => "",

	/*
    |--------------------------------------------------------------------------
    | State Parameter
    |--------------------------------------------------------------------------
    |
    | a-z
	| 0-9
	| - but not as a starting or ending character
    |
    */
	'tenant-name-length' => 40
];