<?php

use App\Models\OauthClient;
use Illuminate\Database\Seeder;

/**
 * Create a single Oauth Client
 */
class OauthClientsTableSeeder extends Seeder
{
	/**
	 * @var \App\Models\OauthClient
	 */
	protected $oauth_client;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(OauthClient $oauth_client)
	{
		$this->oauth_client = $oauth_client;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$id 	= env('OAUTH_CLIENT_ID', '1');
    	$secret = env('OAUTH_CLIENT_SECRET', uniqid());
    	$name 	= env('OAUTH_CLIENT_NAME', 'Stryve App');

        $this->oauth_client->createClient($id, $secret, $name);
    }
}
