<?php

use App\Models\ReservedSubdomain;
use Illuminate\Database\Seeder;

/**
 * Insert pre-determined resserved subdomains
 */
class ReservedSubdomainsTableSeeder extends Seeder
{
	/**
	 * @var \App\Models\ReservedSubdomain
	 */
	protected $reserved_subdomain;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(ReservedSubdomain $reserved_subdomain)
	{
		$this->reserved_subdomain = $reserved_subdomain;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$subdomains = json_decode(file_get_contents(stryve_path().'/Database/SeedData/reserved_subdomains.json'));

		foreach ($subdomains as $subdomain)
		{
			// trim and convert to lowercase
			$subdomain = lowertrim($subdomain);

			// make sure its a valid subdomain
			if(isValidSubdomain($subdomain))
	        	$this->reserved_subdomain->createReservedSubdomain($subdomain);
	    }
    }
}
