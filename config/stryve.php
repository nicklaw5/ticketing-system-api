<?php

return [
	
	/**
	 * Are we accepting registrations at the moment?
	 */

	'accepting-registraions' => true,

	/**
	 * Various default/central configurations for tenants
	 */
	'tentant' => [

		'subdomain' => [

			// The maximum allowable character length for a
			// tenant's subdomain
			'length' => 40,

			// The regular expression for allowable characters in a
			// subdomain: a-Z, 0-9, and hypens (no hypens at start or end)
			'regex' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]))*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/ig'
		],

		
	],
	
];