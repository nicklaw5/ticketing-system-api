<?php

use App\Models\Timezone;
use Illuminate\Database\Seeder;

class TimezonesTableSeeder extends Seeder
{
	/**
	 * @var \App\Models\Timezone
	 */
	protected $timezone;

	/**
	 * Instantiate a new instance
	 */
	public function __construct(Timezone $timezone)
	{
		$this->timezone = $timezone;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezone_groups = json_decode(file_get_contents(stryve_path().'/Database/SeedData/timezones.json'));

        $timezones_array = [];

		foreach ($timezone_groups as $timezone_group)
		{
			foreach ($timezone_group->zones as $zone) 
			{
				$timezones_array[] = [
					'group' 		=> 	$timezone_group->group,
					'name'			=>	$zone->name,
					'value'			=>	$zone->value,
					'created_at' 	=> 	\Carbon\Carbon::now(),
					'updated_at' 	=> 	\Carbon\Carbon::now()
				];
			}
		}	

		$this->timezone->insert($timezones_array);
    }
}
