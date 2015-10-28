<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NewTenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTypesTableSeeder::class);

        Model::reguard();
    }
}

class UserTypesTableSeeder
{
    $types = [
        ['user_type'	=>	'test_type_1'],
        ['user_type'	=>	'test_type_2']
    ];

    \DB::table('user_types')->insert($types);
}