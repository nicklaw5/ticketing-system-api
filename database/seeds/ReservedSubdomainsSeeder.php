<?php

use App\ReservedSubdomain;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ReservedSubdomainsSeeder extends Seeder
{
	/**
	 * @var \App\Subdomain
	 */
	protected $subdomain;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(Subdomain $subdomain)
	{
		$this->subdomain = $subdomain;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$subdomains = json_decode(file_get_contents(stryve_path().'/Database/SeedData/reserved_subdomains.json'));

		foreach ($subdomains as $value) {
	        $this->subdomain->createOrUpdate([
	        		'subdomain' => $value
	        	]
	        );
	    }
    }
}