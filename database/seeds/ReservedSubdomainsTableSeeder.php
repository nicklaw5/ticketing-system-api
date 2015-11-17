<?php

use Illuminate\Database\Seeder;
use App\Models\ReservedSubdomain;

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

    	$subdomains_array = [];

		foreach ($subdomains as $subdomain)
		{
			$subdomain = lowertrim($subdomain);

			if(isValidSubdomain($subdomain))
			{
				$subdomains_array[] = [
					'subdomain'		=>	$subdomain,
					'created_at' 	=> 	\Carbon\Carbon::now(),
					'updated_at' 	=> 	\Carbon\Carbon::now()
				];
			}
	    }

	    $this->reserved_subdomain->insert($subdomains_array);
    }
}
