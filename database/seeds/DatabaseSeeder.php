<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(LocalesTableSeeder::class);
        $this->call(TimezonesTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(ReservedSubdomainsTableSeeder::class);

        Model::reguard();
    }
}
