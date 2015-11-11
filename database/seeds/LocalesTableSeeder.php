<?php

use App\Models\Locale;
use Illuminate\Database\Seeder;

class LocalesTableSeeder extends Seeder
{
	/**
	 * @var \App\Models\Locale
	 */
	protected $locale;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(Locale $locale)
	{
		$this->locale = $locale;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = json_decode(file_get_contents(stryve_path().'/Database/SeedData/locales.json'));

		foreach($locales as $value)
		{
			$locale 		= new $this->locale;
			$locale->locale	= $value;
			$locale->save();	
		}	
    }
}
